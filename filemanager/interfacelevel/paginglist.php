<form id="formpaging" name="formpaging" method="post" action="?<? echo $_SERVER['QUERY_STRING'];?>">
	<div id="subpaging" onMouseOver="showSubPaging();" onMouseOut="setSubPagingTimeout();">
		<div id="subpaging_close" onClick="hideSubPaging();" title="Close"></div>
		<div id="actualpagelabel">Current page:</div>
		<div id="actualpage">
			<input type="text" id="actualpageinput" name="actualpageinput" value="<? echo $actual_page;?>">
		</div>
		<div id="totalofpages">of <? echo $total_of_pages;?> pages</div>
		
		<img src="images/toolbaritems/separator.gif" width="1" height="20" style="float:left;" />
		
		<div id="maxpageelementsnumberlabel">Elements per page:</div>
		<div id="maxpageelementsnumber">
			<input type="text" id="maxpageelementsnumberinput" name="maxpageelementsnumberinput" value="<? echo $elements_for_page;?>">
		</div>
		<div id="gotopage" onClick="reloadPage();"></div>
	</div>
	
	<div id="paging">
		<div onMouseOver="showSubPaging();" onMouseOut="setSubPagingTimeout();">
			<div id="firstpage" class="<? echo is_numeric($first_page[0]) ? "mceButtonNormal" : "mceButtonDisabled";?>" onClick="goToPage('<? echo $first_page[0];?>');"></div>
			<div id="previouspage" class="<? echo is_numeric($previous_page[0]) ? "mceButtonNormal" : "mceButtonDisabled";?>" onClick="goToPage('<? echo $previous_page[0];?>');"></div>
			<div id="nextpage" class="<? echo is_numeric($next_page[0]) ? "mceButtonNormal" : "mceButtonDisabled";?>" onClick="goToPage('<? echo $next_page[0];?>');"></div>
			<div id="lastpage" class="<? echo is_numeric($last_page[0]) ? "mceButtonNormal" : "mceButtonDisabled";?>" onClick="goToPage('<? echo $last_page[0];?>');"></div>
		</div>
		
		<div id="sort">
			<img src="images/toolbaritems/separator.gif" width="1" height="20" style="float:left;" />
			<div id="filesortlabel">Order by:</div>
			<div id="sortby">
				<select id="sortbyselect" name="sortbyselect">
					<option value="0">-------</option>
					<option value="1" <? echo $sort_by == "1" ? "selected" : "";?>>Name</option>
					<option value="3" <? echo $sort_by == "3" ? "selected" : "";?>>Type</option>
					<option value="5" <? echo $sort_by == "5" ? "selected" : "";?>>Size</option>
					<option value="6" <? echo $sort_by == "6" ? "selected" : "";?>>Date</option>
				</select>
			</div>
			<div id="sortorder">
				<select id="sortorderselect" name="sortorderselect">
					<option value="asc" <? echo $sort_order == "asc" ? "selected" : "";?>>Ascending</option>
					<option value="desc" <? echo $sort_order == "desc" ? "selected" : "";?>>Descending</option>
				</select>
			</div>
			<div id="reload" onClick="reloadPage();"></div>
		</div>
	</div>
</form>
