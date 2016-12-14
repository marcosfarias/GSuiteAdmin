<?php

namespace App\Http\Controllers;

use App\Group;
use App\GroupMember;
use App\GSuiteConnectionConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Redirect;


class GroupsMembersController extends Controller
{

	/**
	 * Este método restringe o acesso desta classe somente à usuários autenticados.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}
	
	/**
	 * 
	 * @param unknown $id
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	public function index($id) {
	
		//echo "ID = ";
		//var_dump($id);
		$group = Group::findOrFail($id);
	
		//echo "GROUP = ";
		//var_dump($group);
		
		$groupMembers = DB::table('group_members')
		->where('group_id', '=', $id)
		->get();
		
		//
		return view('groupsMembers.list',[ 'group' => $group, 'groupMembers' => $groupMembers]);
	}
	
	/**
	 * 
	 * @param unknown $id
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	public function add($id) {
		//
		//var_dump($id);
		$group = Group::findOrFail($id);
		
		return view('groupsMembers.form',[ 'group' => $group]);
	}
	
	/**
	 * A group member can be a user or another group. 
	 * The groupKey is the new member's group email address or the group's unique id.
	 * If you add a group as a member of another group, there may be a delay of up to 10 minutes before the child group's members appear as members of the parent group.
	 * In addtion, the API returns an error for cycles in group memberships. For example, if group1 is a member of group2, group2 cannot be a member of group1.
	 * @see https://developers.google.com/admin-sdk/directory/v1/guides/manage-group-members#create_member
	 * @param Request $request
	 * @return unknown
	 */
	public function save(Request $request) {
		//
		DB::beginTransaction();
		//
		try {
			//
			$groupMember = new GroupMember();
			//
			$groupMember = $groupMember->create($request->all());
			
			//
			$group = Group::findOrFail($groupMember->group_id);
			$groupKey = $group->email;
			//
			// --------------------------------------------------------------------------------------------------------
			//
			$service = new \Google_Service_Directory(GSuiteConnectionConfig::getClientToGoogleCloud());
			//
			$googleGroupMember = new \Google_Service_Directory_Member();
			//
			$googleGroupMember -> setEmail($groupMember->email);
			$googleGroupMember -> setRole($groupMember->role);
			
			$createGroupMemberResult = $service->members->insert($groupKey, $googleGroupMember);
			//var_dump($createGroupMemberResult);
			//
			// --------------------------------------------------------------------------------------------------------
			//
			DB::update('update groups set directMembersCount=directMembersCount+1 where id = ?', [$groupMember->group_id]);
			//
			DB::commit();
			//
			\Session::flash('success_message', 'Novo Membro de Grupo cadastrado com sucesso!');
		}
		catch (Google_IO_Exception $gioe)
		{
			DB::rollback();
			echo "Error in connection: ".$gioe->getMessage();
			\Session::flash('fail_message', "Error in connection: ".$gioe->getMessage());
		}
		catch (Google_Service_Exception $gse)
		{
			DB::rollback();
			echo "Error in connection: ".$gse->getMessage();
			\Session::flash('fail_message', "Group Member already exists: ".$gse->getMessage());
		} catch (\Exception $e) {
			DB::rollback();
			echo "Error in connection: ".$e->getMessage();
			\Session::flash('fail_message', $e->getMessage());
		}
		//
		return Redirect::to('groups/'.$groupMember->group_id.'/members');
	}
	
	/**
	 * 
	 * @param $id
	 * @param $groupMemberId
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	public function edit($id,$groupMemberId) {
		//
		$group = Group::findOrFail($id);
		//
		$groupMember = GroupMember::findOrFail($groupMemberId);
		//
		return view('groupsMembers.form', ['group' => $group, 'groupMember' => $groupMember]);
	}
	
	/**
	 * The groupKey is the group's email address or the group's unique id, and the memberKey is the user's or group's primary email address, a user's alias email address, or the user's unique id.
	 * @see https://developers.google.com/admin-sdk/directory/v1/guides/manage-group-members#update_member
	 * @param $id App Database Id of the Group that which member is going to be updated
	 * @param $groupMemberId App Database Id of the Group Member that is going to be updated
	 * @param $request
	 */
	public function update($id, $groupMemberId, Request $request) {
		//
		DB::beginTransaction();
		//
		try {
			//
			$group = Group::findOrFail($id);
			$groupKey = $group->email;
			
			//
			$groupMember = GroupMember::findOrFail($groupMemberId);
			$groupMemberKey = $groupMember->email;
		
			//
			// --------------------------------------------------------------------------------------------------------
			//
			$service = new \Google_Service_Directory(GSuiteConnectionConfig::getClientToGoogleCloud());
			//
			$googleGroupMember = $service->members->get($groupKey, $groupMemberKey);
			//
			$googleGroupMember -> setRole($groupMember->role);
			//
			$service->members->update($groupKey, $groupMemberKey, $googleGroupMember);
			//
			// --------------------------------------------------------------------------------------------------------
			//
			$groupMember->update($request->all());
			//
			DB::commit();
			//
			\Session::flash('success_message', 'Membro do Grupo atualizado com sucesso!');
			//
		} catch (Google_IO_Exception $gioe) {
			DB::rollback();
			\Session::flash('fail_message', $gioe->getMessage());
			echo $gioe->getMessage();
		} catch (Google_Service_Exception $gse) {
			DB::rollback();
			\Session::flash('fail_message', $gse->getMessage());
			echo $gse->getMessage();
		} catch (\Exception $e) {
			DB::rollback();
			\Session::flash('fail_message', $e->getMessage());
			echo $e->getMessage();
		}
	
		//
		return Redirect::to('groups/'.$id.'/members');
	}
	
	/**
	 * When a member is deleted:
	 * . Members you remove no longer receive email addressed to the group.
	 * . Removing a member from a group does not delete the user's account.
	 * . If you delete the group owner, the group still works normally. As an administrator, you can manage the group or assign ownership to another group member
	 * 
	 * @see https://developers.google.com/admin-sdk/directory/v1/guides/manage-group-members#delete_member
	 * @param unknown $id
	 * @return unknown
	 */
	public function delete($id, $groupMemberId) {
		//
		DB::beginTransaction();
		//
		try {
			//
			$group = Group::findOrFail($id);
			$groupKey = $group->email;
			
			//
			$groupMember = GroupMember::findOrFail($groupMemberId);
			$groupMemberKey = $groupMember->email;
			
			//
			// --------------------------------------------------------------------------------------------------------
			//
			$service = new \Google_Service_Directory(GSuiteConnectionConfig::getClientToGoogleCloud());
			//
			$service->members->delete($groupKey, $groupMemberKey);
			//
			// --------------------------------------------------------------------------------------------------------
			//
			$groupMember->delete();
			//
			DB::update('update groups set directMembersCount=directMembersCount-1 where id = ?', [$groupMember->group_id]);
			//
			DB::commit();
			//
			\Session::flash('success_message', 'Membro de Grupo Removido com sucesso!');
			//
		} catch (Google_IO_Exception $gioe) {
			DB::rollback();
			\Session::flash('fail_message', $gioe->getMessage());
		} catch (Google_Service_Exception $gse) {
			DB::rollback();
			\Session::flash('fail_message', $gse->getMessage());
		} catch (\Exception $e) {
			DB::rollback();
			\Session::flash('fail_message', $e->getMessage());
		}
	
		//
		return Redirect::to('groups/'.$id.'/members');
	}
}
