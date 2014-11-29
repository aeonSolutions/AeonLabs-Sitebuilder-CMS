<?
require_once($globvars['local_root']."filemanager/basiclevel/Matriz.php");

$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by']: 1;
$sort_order = !empty($_GET['sort_order']) ? $_GET['sort_order'] : 'asc';
if(!empty($sort_by) && is_numeric($sort_by)) {
	$files = $sort_order == "desc" ? Matriz::ordenaDescrescentemente($files,$sort_by) : Matriz::ordenaCrescentemente($files,$sort_by);
	$files = $files[0];
}


require_once($globvars['local_root']."filemanager/basiclevel/Paging.php");
$total_of_elements = count($files);
$elements_for_page = !empty($_GET['elements_for_page']) ? $_GET['elements_for_page'] : 20;
$actual_page = !empty($_GET['actual_page']) ? $_GET['actual_page'] : 1;
$paging = new Paging($total_of_elements,$elements_for_page,$actual_page,"&path=".$path.$url_vars,0);

$actual_page = $paging->pager->page;
$begin_index = $paging->begin_index;
$end_index = $paging->end_index;

$total_of_pages = $paging->pager->numPages;
$first_page = $paging->paging_data[0];
$previous_page = $paging->paging_data[1];
$next_page = $paging->paging_data[count($paging->paging_data)-2];
$last_page = $paging->paging_data[count($paging->paging_data)-1];
?>