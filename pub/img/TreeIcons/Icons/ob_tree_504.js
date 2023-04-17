//<!--
//		ASP TreeView
//	
//		Copyright obout inc      http://www.obout.com

var ob_tree_js_version="504",ob_tree_first_call=true,tree_node_exp_col=false,ob_tb2,ob_last,ob_url2,ob_sids=null,ob_ivl="",ob_iar=0,ob_op2,tree_selected_id,ob_prev_selected,tree_parent_id,tree_selected_path,ob_xmlhttp2,ob_alert2; /*@cc_on @*//*@if (@_jscript_version >= 5);try{ob_xmlhttp2=new ActiveXObject("Msxml2.XMLHTTP")}catch(e){try {ob_xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP")}catch(E){}};@else;ob_xmlhttp2=false;ob_alert2=true;@end @*/if (!ob_xmlhttp2 && !ob_alert2){try {ob_xmlhttp2=new XMLHttpRequest();}catch(e){}}function ob_rsc() {if (ob_xmlhttp2.readyState==4){ob_tb2.className="none";ob_tb2.innerHTML=ob_xmlhttp2.responseText;}}function ob_t24(){if(ob_xmlhttp2){ob_xmlhttp2.open("GET",ob_url2,true);ob_xmlhttp2.onreadystatechange=ob_rsc;ob_xmlhttp2.send(null);}}function ob_t26(){ob_ivl=window.setInterval("ob_t28()",200);}function ob_t28(){if(ob_sids==null){window.clearInterval(ob_ivl);ob_t25(document.getElementById(ob_last));return;}if(ob_xmlhttp2.readyState==4 || ob_xmlhttp2.readyState==0){if(ob_iar==ob_sids.length){window.clearInterval(ob_ivl);ob_t25(document.getElementById(ob_last));return;}ob_t25(document.getElementById(ob_sids[ob_iar]));ob_iar=ob_iar+1;}}

function ob_t21(os, url) 
{
	// Switch plus-minus images when clicked.
	
	// ob_node_id is ID of exapanded/collapsed node.
	var currentlySelected = os.parentNode.parentNode.firstChild.nextSibling.nextSibling;
	var ob_node_id = currentlySelected.id;
    var ot = os.parentNode.parentNode.parentNode.parentNode.nextSibling;

    // Uncomment next line to save nodes state in cookies.
    //ob_saveNodeState( ot, ob_node_id );
    
    var lensrc = (os.src.length - 8);
    var s = os.src.substr(lensrc, 8);

    if ((s == "inus.gif")||(s == "us_l.gif")) {
		
		// EVENT. Expanded node will be collapsed.
		
		if (s == "inus.gif") 
		{
			ot.style.display = "none";
			os.src = ob_style + "/plusik.gif";
		}
		else 
		{
			ot.style.display = "none";
			os.src = ob_style + "/plusik_l.gif";
		}
    }

    if ((s == "usik.gif")||(s == "ik_l.gif")) 
    {
		// EVENT. Collapsed node will be expanded.
    
		if (typeof (ob_expand_single) != 'undefined' && ob_expand_single)
			ob_expandSingle(currentlySelected);

		if (s == "usik.gif") 
		{
			ot.style.display = "block";
			os.src = ob_style + "/minus.gif";
		}
		else 
		{
			ot.style.display = "block";
			os.src = ob_style + "/minus_l.gif";
			// If dynamic loading URL is supplied, call loading function.
			if (typeof(url) != 'undefined' && url != "") 
			{
				var s = os.parentNode.parentNode.parentNode.parentNode.nextSibling.firstChild.firstChild.firstChild.nextSibling.innerHTML;
				if (s != "Loading ...") 
				{
					return;
				}
				ob_url2 = url;
				ob_tb2 = os.parentNode.parentNode.parentNode.parentNode.nextSibling.firstChild.firstChild.firstChild.nextSibling;
				window.setTimeout("ob_t24()", 100);
			}
		}
    }
    
	// select collapsed node if its child was previously selected
    if(tree_selected_path!=null){
		var s = os.src.substr((os.src.length - 8), 8);
		if ((s=="ik_l.gif")||(s=="usik.gif")){
			//if tree_selected_path contains collapsed node id.
			var e = os.parentNode.parentNode.firstChild.nextSibling.nextSibling;
			var a = tree_selected_path.split(",");
			for (i=0; i<a.length; i++) {
				if(a[i]==e.id){
					tree_node_exp_col = true;
					ob_t22(e);
					tree_node_exp_col = false;
					return;
				}
			}
		}
	}
	
	// EVENT. Node collapsed OR expanded.
}

function ob_t22(ob_od, ev) {
	// Highlight selected node
	// Change class name and assign id to variable tree_selected_id
	if (typeof(ob_od.className) == 'undefined' && ob_od.parentNode.className == 'ob_t2') ob_od = ob_od.parentNode;
	if (ob_od.id == "") return;
	
	// EVENT. Before node is selected.

	// make sure that if this is the first select of a node and ExpandSingle is true,
	// the rule is applied
	if (typeof (ob_expand_single) != 'undefined' && ob_expand_single && typeof(ob_tree_first_call) != 'undefined' && ob_tree_first_call)
	{
		parentNode = ob_getParentOfNode(ob_od);
		if (parentNode != null) ob_expandSingle(parentNode);
	}
	
	try
	{
		// ensure visible
		ob_nodeEnsureVisible(ob_od);
	}
	catch (e) {}

	// the previously selected node
	prevSelected = document.getElementById(tree_selected_id);

	// for edit mode only
	if ((prevSelected != null)&&typeof(ob_tree_editnode_enable) != 'undefined'&&(ob_tree_editnode_enable==true)) ob_attemptEndEditing(ob_od);

	if(ob_prev_selected!=null && typeof(ob_sn2) == 'undefined')
		ob_prev_selected.className = "ob_t2";

	ob_prev_selected = ob_od;
	ob_od.className = "ob_t3";
		
	// for edit mode only
	if (typeof(ob_tree_editnode_enable) != 'undefined'&&ob_tree_editnode_enable==true){ob_attemptStartEditing(ob_od)};
	
	// for multiselect mode only
	if (typeof(ob_sn2) != 'undefined') ob_multiselect(ob_od, ev);

    // the last selected node is set to the current node
    ob_op2 = ob_od;
	// store the current node id as the last selected node
	tree_selected_id = ob_od.id;	
    
    // Find path to selected and extend the path
    var sel_id;
	if(ob_od.parentNode.parentNode.parentNode.parentNode.parentNode.className=="ob_di2")
	{
		tree_selected_path = tree_selected_id;
		tree_parent_id = "root";
	}
	else 
	{
		ob_od = ob_od.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.firstChild.firstChild.firstChild.firstChild.nextSibling.nextSibling;
		tree_parent_id = ob_od.id;
		tree_selected_path = tree_parent_id+","+tree_selected_id;
		ob_t20(ob_od);
	}
	
	// EVENT. After node is selected.
}

function ob_t20(e){
	// Extend all parents up and populate tree_selected_path
	
    var os = e.parentNode.firstChild.firstChild;

    if (os != null) {
		if ((typeof os != "undefined") && (os.tagName == "IMG")) {
			var lensrc = (os.src.length - 8);
			var s = os.src.substr(lensrc, 8);
			if ((s == "usik.gif") || (s == "ik_l.gif")) {
				os.onclick();
			}
			if(e.parentNode.parentNode.parentNode.parentNode.parentNode.className=="ob_di2"){return};
			e=e.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.firstChild.firstChild.firstChild.firstChild.nextSibling.nextSibling
			tree_selected_path=e.id+","+tree_selected_path;
			ob_t20(e);
		}
	}
}

function ob_t23(e){
	// To expand-collapse node by clicking on node text.
	// Find first image with plus-minus and call onclick()

    var os = e.parentNode.parentNode.firstChild.firstChild;

    if (os != null) {
		if ((typeof os != "undefined") && (os.tagName == "IMG")) {
			var lensrc = (os.src.length - 8);
			var s = os.src.substr(lensrc, 8);
			if ((s == "inus.gif") || (s == "usik.gif") || (s == "us_l.gif") || (s == "ik_l.gif")) {
				os.onclick();
			}
		}
		else {
			ob_t23(e.parentNode);
		}
	}
}

function ob_t25(ob_od) 
{
	// When tree is first loaded - Highlight and Extend selected node.
	if(ob_od==null) {
		//alert("Selected node does not exists or its id is not unique.");
		return
	};
	// Extend.
	var e, lensrc, s;
    e = ob_od.parentNode.firstChild.firstChild;
	if ((typeof e.src != "undefined") && (e.tagName == "IMG")) {
		s = e.src.substr((e.src.length - 8), 8);
		if ((s == "usik.gif") || (s == "ik_l.gif")) {
			// Comment out or delete this line if you don't want to expand selected node.
			e.onclick();
		}
	}
	// Highlight and populate path.
	ob_t22(ob_od);
}

function ob_tall(exp) {
	// To expand all nodes ob_tall(1)
	// To collapse all nodes ob_tall(0)
	
	var i, e, lensrc, s
	for (i=0; i<document.images.length; i++) {
		e = document.images[i];
		lensrc = (e.src.length - 8);
		s = e.src.substr(lensrc, 8);
		if (exp == 1) {
			if ((s == "usik.gif") || (s == "ik_l.gif")) {
				e.onclick();
			}
		}
		else
			if ((s == "inus.gif") || (s == "us_l.gif")) {
				e.onclick();
			}
	}
}

function ob_t2c(e) {
	// To check/uncheck checkboxes in children.
	if(ob_hasChildren(e.parentNode)) {
		var ob_t2in=e.parentNode.parentNode.parentNode.parentNode.nextSibling.getElementsByTagName("input");
		for (var i=0; i<ob_t2in.length; i++) {
			if (e.checked==true) {
				ob_t2in[i].checked=true;
			}
			else {
				ob_t2in[i].checked=false;
			}
		}
	}
	// uncheck parent 
	if(e.checked==false) {
		ob_t2_unchk_parent(e.parentNode);
	}
}


function ob_t2_list_checked() {
	// Make string with checked checkboxes IDs.
	
	var ob_t2in,ob_t2s,ob_t2checked="";
	ob_t2in=document.getElementsByTagName("input");
	for (var i=0; i<ob_t2in.length; i++) {
		ob_t2s=ob_t2in[i].id;
		if ((ob_t2s.substr(0,4)=="chk_") && (ob_t2in[i].checked)) {
			ob_t2checked=ob_t2checked+ob_t2s+",";
		}
	}
	return ob_t2checked;
}


function ob_t2_unchk_parent(e) {
	// if checkbox unchecked, uncheck all its parents up to root.
	e = ob_getParentOfNode(e);
	if (e!=null){
		if ((e.firstChild!=null) && (e.firstChild.id.substr(0,4)=="chk_")) {
			e.firstChild.checked=false;
			ob_t2_unchk_parent(e);
		}
	}
}


function ob_hasChildren(ob_od)
{
	try
	{
		return (ob_od.parentNode.parentNode.parentNode.parentNode.tagName.toLowerCase() == 'div' && ob_od.parentNode.parentNode.parentNode.parentNode.className.toLowerCase() == 'ob_t2b');
	}
	catch (e)
	{
		return false;
	}
}

function ob_isExpanded(ob_od)
{
	try
	{
		imgSrc = ob_od.parentNode.firstChild.firstChild.src;
		lenSrc = imgSrc.length - 8;
		imgSrcLast = imgSrc.substr(lenSrc, 8);
		return (imgSrcLast == 'inus.gif' || imgSrcLast == 'us_l.gif');
	}
	catch (e)
	{
		return false;
	}
}

function ob_nodeIsChildOf(node, parent)
{
	try
	{
		return ob_getParentOfNode(node) == parent;
	}
	catch (e)
	{
	}

	return false;
}

function ob_nodeIsSubNodeOf(node, parent)
{
	try
	{
		if (parent != null)
		{
			do
			{
				node = ob_getParentOfNode(node);
				if (node == parent) return true;
			} 
			while (node != null)
		}
	}
	catch (e)
	{
	}

	return false;
}

function ob_hasSiblings(ob_od)
{
	try
	{
		return (ob_getChildCount(ob_getParentOfNode(ob_od)) > 1);
	}
	catch (e)
	{
		return false;
	}
}

function ob_getParentOfNode (ob_od)
{
	try
	{
		if(ob_od.parentNode.parentNode.parentNode.parentNode.parentNode.className=="ob_di2") { return null }
		else 
		{
			if (ob_hasChildren(ob_od.parentNode)) return ob_od.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.firstChild.firstChild.firstChild.firstChild.nextSibling.nextSibling;
			else return	ob_od.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.firstChild.firstChild.firstChild.firstChild.nextSibling.nextSibling;
		}
	}
	catch (e)
	{
	}

	return null;
}

function ob_getChildCount (ob_od)
{
	try
	{
		if (ob_hasChildren(ob_od))
			return ob_od.parentNode.parentNode.parentNode.parentNode.firstChild.nextSibling.firstChild.firstChild.firstChild.nextSibling.childNodes.length;
		else return 0;
	}
	catch (e)
	{
	}

	return -1;
}

function ob_getChildAt (ob_od, index, expand)
{
	try
	{
		// if the node supplied exists, has children and the index is correctly formed
		if (ob_od != null && ob_hasChildren(ob_od) && index >= 0)
		{
			if (!ob_isExpanded(ob_od)) 
			try
			{
				ob_od.parentNode.firstChild.firstChild.onclick();
			} catch (e) {}
			return ob_od.parentNode.parentNode.parentNode.parentNode.firstChild.nextSibling.firstChild.firstChild.firstChild.nextSibling.childNodes[index].firstChild.firstChild.firstChild.firstChild.nextSibling.nextSibling;
		}
	}
	catch (e)
	{
	}

	return null;
}

function ob_getIndexOfChild (ob_od)
{
	try
	{
		nodeParent = ob_getParentOfNode (ob_od);
		childCount = ob_getChildCount (nodeParent);
		
		for (i = 0; i < childCount; i++)
			if (ob_getChildAt(nodeParent, i, false) == ob_od) return i;
	}
	catch (e)
	{
	}

	return -1;
}

function ob_getLastChildOfNode (ob_od, expand)
{
	try
	{
		if (ob_hasChildren(ob_od))
		{
			if (!ob_isExpanded(ob_od) && expand)
			{
				try
				{
					ob_od.parentNode.firstChild.firstChild.onclick();
				} catch (e) {}
			}

			lastChild = ob_od.parentNode.parentNode.parentNode.parentNode.firstChild.nextSibling.firstChild.firstChild.firstChild.nextSibling.lastChild.firstChild.firstChild.firstChild.firstChild.nextSibling.nextSibling;
		}
		
		return lastChild;
	}
	catch (e)
	{
	}

	return null;
}

function ob_getFirstChildOfNode (ob_od, expand)
{
	try
	{
		if (ob_hasChildren(ob_od))
		{
			if (!ob_isExpanded(ob_od) && expand)
			{
				try
				{
					ob_od.parentNode.firstChild.firstChild.onclick();
				} catch (e) {}
			}

			if (ob_isExpanded(ob_od))
				firstChild = ob_od.parentNode.parentNode.parentNode.parentNode.firstChild.nextSibling.firstChild.firstChild.firstChild.nextSibling.firstChild.firstChild.firstChild.firstChild.firstChild.nextSibling.nextSibling;
		}
		
		return firstChild;
	}
	catch (e)
	{
	}

	return null;
}

function ob_getNextSiblingOfNode (ob_od)
{
	try
	{
		nxtSibling = ob_od.parentNode.parentNode.parentNode.parentNode.nextSibling;
		if (nxtSibling != null)
		{
			nxtSibling = nxtSibling.firstChild.firstChild.firstChild.firstChild.nextSibling.nextSibling;
		}
		
		return nxtSibling;
	}
	catch (e)
	{
	}

	return null;
}

function ob_getPrevSiblingOfNode (ob_od)
{
	try
	{
		prvSibling = ob_od.parentNode.parentNode.parentNode.parentNode.previousSibling;
		if (prvSibling != null)
		{
			prvSibling = prvSibling.firstChild.firstChild.firstChild.firstChild.nextSibling.nextSibling;
		}
		
		return prvSibling;
	}
	catch (e)
	{
	}

	return null;
}

function ob_getFurthestChildOfNode (ob_od, expand)
{
	fChild = ob_od;

	while (true)
	{
		if (ob_hasChildren(fChild) && (ob_isExpanded(fChild) || expand))
		{
			if (!ob_isExpanded(ob_od) && expand)
			{
				try
				{
					ob_od.parentNode.firstChild.firstChild.onclick();
				} catch (e) {}
			}
		
			if (ob_isExpanded(fChild))
			{
				tmpChild = ob_getLastChildOfNode(fChild);
				if (tmpChild == null) break;
				else fChild = tmpChild;
			}
		}
		else break;
	}
	
	return fChild;
}

function ob_elementBelongsToTree (ob_od)
{
	try
	{
		if (ob_od.tagName.toLowerCase() == "body") return false;
		if (ob_od.className.toLowerCase() == "ob_tree") return true;

		while (ob_od.parentNode.tagName.toLowerCase() != "body")
		{
			if (ob_od.parentNode.className.toLowerCase() == "ob_tree") return true;
			ob_od = ob_od.parentNode;
		}
		
		return false;
	}
	catch (e)
	{
	}

	return false;
}

function ob_getFirstNodeOfTree ()
{
	try
	{
		tree_div = document.getElementById(ob_tree_id);
		if (tree_div != null)
		{
			rootNode = tree_div.childNodes[0].childNodes[0].childNodes[0].childNodes[0].childNodes[0].childNodes[2];
			if (rootNode != null && rootNode.className == 'ob_t2') return rootNode;
		}
	}
	catch (e)
	{
	}
}

function ob_getNodeUp (ob_od, expand)
{
	prevSibling = ob_getPrevSiblingOfNode(ob_od);
	if (prevSibling != null) 
	{
		prevSibling = ob_getFurthestChildOfNode(prevSibling, expand);
		return prevSibling;
	}
	else
	{
		nodeParent = ob_getParentOfNode(ob_od);
		if (nodeParent != null)
		{
			return nodeParent;
		}
	}

	return null;
}

function ob_getNodeDown (ob_od, expand)
{	
	if (ob_hasChildren(ob_od) && (ob_isExpanded(ob_od) || expand))
	{
		nxtSibling = ob_getFirstChildOfNode(ob_od, expand);
		return nxtSibling;
	}
	else
	{
		nxtSibling = ob_getNextSiblingOfNode(ob_od);
		if (nxtSibling != null) return nxtSibling;
		
		nodeParent = ob_od;
		do
		{
			nodeParent = ob_getParentOfNode(nodeParent);
			if (nodeParent != null)
			{
				nxtSibling = ob_getNextSiblingOfNode(nodeParent);
				if (nxtSibling != null) return nxtSibling;
			}
		} while (nodeParent != null && nodeParent.className.toLowerCase() != "ob_tree")
	}
	
	return null;
}

function ob_getExpanded (ob_od, onlyChildren)
{
	exp = '';
	if (!ob_od) ob_od = ob_getFirstNodeOfTree();
	node = ob_od;
		
	if (node != null)
	{
		node = ob_getNodeDown(node);
		while (node != null && ((onlyChildren && ((ob_od == null) || ob_nodeIsChildOf(node, ob_od))) || (!onlyChildren && ((ob_od == null) || ob_nodeIsSubNodeOf(node, ob_od)))))
		{
			if (ob_hasChildren(node) && ob_isExpanded(node)) exp += ((exp.length > 0) ? ',' : '') + node.id;
			node = onlyChildren ? ob_getNextSiblingOfNode(node) : ob_getNodeDown(node);
		}
	}
	
	return exp;
}

function ob_getCollapsed (ob_od, onlyChildren)
{
	exp = '';
	if (!ob_od) ob_od = ob_getFirstNodeOfTree();
	node = ob_od;
		
	if (node != null)
	{
		node = ob_getNodeDown(node);
		while (node != null && ((onlyChildren && ((ob_od == null) || ob_nodeIsChildOf(node, ob_od))) || (!onlyChildren && ((ob_od == null) || ob_nodeIsSubNodeOf(node, ob_od)))))
		{
			if (ob_hasChildren(node) && !ob_isExpanded(node)) exp += ((exp.length > 0) ? ',' : '') + node.id;
			node = onlyChildren ? ob_getNextSiblingOfNode(node) : ob_getNodeDown(node);
		}
	}
	
	return exp;
}

function ob_expandSingle(ob_od)
{
	if (typeof(ob_tree_first_call) != 'undefined' && ob_tree_first_call)
	{
		ob_tree_first_call = false;
		parentNode = ob_getParentOfNode(ob_od);
		do
		{
			if (parentNode != null) ob_expandSingle (parentNode);
			else break;
			parentNode = ob_getParentOfNode(parentNode);
		} while (true);
	}
	
	// nodes before the current node
	prevSibling = ob_getPrevSiblingOfNode(ob_od);
	do
	{
		// if there is a node before
		if (prevSibling != null)
		{
			try
			{
				// if it's expanded
				if (ob_isExpanded(prevSibling))
				{
					// try to collapse it
					tmpOs = prevSibling.parentNode.firstChild.firstChild;
					if (tmpOs != null) tmpOs.onclick();
				}
			}
			catch (e) {}
			
			// then get the prev node of this node
			prevSibling = ob_getPrevSiblingOfNode(prevSibling);
		}
		// otherwise, exit loop
		else break;
		
	} while (true);
	
	// nodes after the curent node
	nextSibling = ob_getNextSiblingOfNode(ob_od);
	do
	{
		// if there is a node after
		if (nextSibling != null)
		{
			try
			{
				// if it's expanded
				if (ob_isExpanded(nextSibling))
				{
					// try to collapse it
					tmpOs = nextSibling.parentNode.firstChild.firstChild;
					if (tmpOs != null) tmpOs.onclick();
				}
			}
			catch (e) {}
			
			// then get the next node of this node
			nextSibling = ob_getNextSiblingOfNode(nextSibling);
		}
		// otherwise, exit loop
		else break;
		
	} while (true);
}

function ob_t2_Add(parentId, childId, textOrHTML, expanded, image, subTreeURL)
{
	// get the parentNode
	pNode = document.getElementById(parentId);
	// if the parent doesn't exist
	if (!pNode) 
	{
		alert("Parent doesn't exist!");
		return;
	}
	else
	{
		// verify if the parent is a tree node
		if (pNode.className.toLowerCase() != 'ob_t2' && pNode.className.toLowerCase() != 'ob_t3')
		{
			alert("Parent node is not a valid tree node!");
			return;
		}
	}
	// if the parent node is not selected, select it now
	dParent = pNode.parentNode.parentNode.parentNode.parentNode;
	
	// if a node with the same id exists
	if (document.getElementById(childId) != null) 
	{
		alert('An element with the specified childId already exists!');
		return;
	}
	
	// if parent doesn't have any child nodes
	if (!ob_hasChildren(pNode))
	{
		// add the container for child nodes
		dParent.innerHTML = dParent.innerHTML + '<table class=ob_t2c border="0" cellspacing="0" cellpadding="0" style="display:none;"><tr><td><div class=ob_d5></div></td><td class=ob_t5></td></tr></table>';
		
		// mark the node as having children
		dParent.className = 'ob_t2b';
		dParent.firstChild.className = 'ob_t2b';
		// adding the plus/minus sign
		if (ob_getLastChildOfNode(ob_getParentOfNode(pNode), true) == pNode) dParent.firstChild.firstChild.firstChild.firstChild.innerHTML = '<img alt="" src="' + ob_style + '/plusik_l.gif" onclick="ob_t21(this, \'\')">';
		else dParent.firstChild.firstChild.firstChild.firstChild.innerHTML = '<img alt="" src="' + ob_style + '/plusik_l.gif" onclick="ob_t21(this, \'\')">';
	}
	else
	{
		// get the last node of parent (will be the prev sibling of the node that will be added) also expanding the parent node if needed
		prevS = ob_getLastChildOfNode(pNode, true);
		
		// and change the background and image (since it will no longer be the last node)
		if (!ob_hasChildren(prevS)) prevS.parentNode.parentNode.parentNode.parentNode.firstChild.firstChild.firstChild.firstChild.firstChild.src = ob_style + "/hr.gif";
		else 
		{
			if (!ob_isExpanded(prevS)) prevS.parentNode.parentNode.parentNode.parentNode.firstChild.firstChild.firstChild.firstChild.firstChild.src = ob_style + "/plusik.gif";
			else prevS.parentNode.parentNode.parentNode.parentNode.firstChild.firstChild.firstChild.firstChild.firstChild.src = ob_style + "/minus.gif";

			prevS.parentNode.parentNode.parentNode.parentNode.firstChild.nextSibling.firstChild.firstChild.firstChild.style.backgroundImage = "url(" + ob_style + "/vertical.gif)";
		}
		prevS.parentNode.parentNode.parentNode.parentNode.firstChild.firstChild.firstChild.firstChild.style.backgroundImage = "url(" + ob_style + "/vertical.gif)";
	}
	
	// create our actual node
	div = document.createElement('div');
	div.className = 'ob_t2c';
	div.innerHTML = '<table border=0 cellspacing=0 cellpadding=0><tr><td class="ob_t6"><img ' + ((subTreeURL != null) ? 'src="' + ob_style + '/plusik_l.gif" onclick="ob_t21(this, \'' + subTreeURL + '\')"' : 'src="' + ob_style + '/hr_l.gif"') + '></td><td class="ob_t4"><div class="ob_d4">' + ((image != null && typeof(ob_icons) != 'undefined') ? '<img src="' + ob_icons + '/' + image + '">' : '') + '</div></td><td id=' + childId + ' onclick="ob_t22(this, event)" class="ob_t2">' + textOrHTML + '</td></tr></table>';
	node = div.firstChild.firstChild.firstChild.firstChild.nextSibling.nextSibling;

	// if the node has a subtree defined, add them too
	if (subTreeURL != null) div.innerHTML += '<table border=0 cellpadding=0 cellspacing=0 style="display: none;"><tbody><tr><td style="background-image: url(\'' + ob_style + '/vertical.gif\');"><div class=ob_d5></div></td><td class="ob_t7">Loading ...</td></tr></tbody>';
	
	// add the node to the parent's node children container
	dParent.firstChild.nextSibling.firstChild.firstChild.firstChild.nextSibling.appendChild(div);
	
	// expand parent if not already expanded and select it
	tree_node_exp_col = true;
	if (tree_selected_id != parentId) document.getElementById(parentId).onclick();
	if (!ob_isExpanded(dParent.firstChild.firstChild.firstChild.firstChild.nextSibling.nextSibling)) dParent.firstChild.firstChild.firstChild.firstChild.firstChild.onclick();
	tree_node_exp_col = false;
	
	// if the node has children and it's marked to be expanded, expand it
	if (expanded) 
	{
		try
		{
			dParent.firstChild.nextSibling.firstChild.firstChild.firstChild.nextSibling.firstChild.firstChild.firstChild.firstChild.firstChild.firstChild.onclick();
		} catch (e) {}
	}	
}

function ob_t2_Remove(childId)
{
	ob_od = document.getElementById(childId);
	if (!ob_od) 
	{
		alert("There is no node with the specified id.");
		return;
	}
	
	try
	{
		nodeParent = ob_getParentOfNode (ob_od);

		// has siblings
		if (ob_hasSiblings(ob_od))
		{
			// if node to remove is last, its prev sibling (if any) will have the vertical image changed
			if (ob_getLastChildOfNode(ob_getParentOfNode(ob_od)) == ob_od)
			{
				// get the node that will become last
				prevS = ob_getPrevSiblingOfNode(ob_od);
				if (prevS != null)
				{
					// and change the background and image
					if (!ob_hasChildren(prevS)) prevS.parentNode.parentNode.parentNode.parentNode.firstChild.firstChild.firstChild.firstChild.firstChild.src = ob_style + "/hr_l.gif";
					else 
					{
						if (!ob_isExpanded(prevS)) prevS.parentNode.parentNode.parentNode.parentNode.firstChild.firstChild.firstChild.firstChild.firstChild.src = ob_style + "/plusik_l.gif";
						else prevS.parentNode.parentNode.parentNode.parentNode.firstChild.firstChild.firstChild.firstChild.firstChild.src = ob_style + "/minus_l.gif";

						prevS.parentNode.parentNode.parentNode.parentNode.firstChild.nextSibling.firstChild.firstChild.firstChild.style.backgroundImage = "none";
					}
					prevS.parentNode.parentNode.parentNode.parentNode.firstChild.firstChild.firstChild.firstChild.style.backgroundImage = 'none';
				}
			}

			// remove the node
			ob_od.parentNode.parentNode.parentNode.parentNode.parentNode.removeChild(ob_od.parentNode.parentNode.parentNode.parentNode);
		}
		// is the only node
		else
		{
			// if the node has a parent
			if (nodeParent != null)
			{
				e = nodeParent.parentNode.parentNode.parentNode.parentNode;
				
				// if parent node is last child
				if (ob_getLastChildOfNode(ob_getParentOfNode(parent)) == parent) 
				{
					e.firstChild.firstChild.firstChild.firstChild.style.backgroundImage = 'none';
					e.firstChild.firstChild.firstChild.firstChild.firstChild.src = ob_style + "/hr_l.gif";
				}
				else 
				{
					e.firstChild.firstChild.firstChild.firstChild.style.backgroundImage = "url(' + ob_style + '/vertical.gif)";
					e.firstChild.firstChild.firstChild.firstChild.firstChild.src = ob_style + "/hr.gif";
				}

				// remove image with plus minus from the parent
				e.removeChild(e.firstChild.nextSibling);

				// remove the node
				ob_od.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.removeChild(ob_od.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode);
			}
			// if the node does not have a parent
			else
			{
				ob_od.parentNode.parentNode.parentNode.parentNode.parentNode.removeChild(ob_od.parentNode.parentNode.parentNode.parentNode);
			}
		}

		if (nodeParent != null)
		{
			// select the parent node
			nodeParent.onclick();
		}
	}
	catch (e)
	{
	}
}

function ob_saveNodeState( objBlockNode, NodeId ) {
	if( objBlockNode.style.display == "block" ) {
		ob_setCookie( NodeId, "false" );
	}
	else {
		ob_setCookie( NodeId, "true" );
	}
}

function ob_setCookie(name, value, expires, path, domain, secure) {
  var curCookie = name + "=" + escape(value) +
      ((expires) ? "; expires=" + expires.toGMTString() : "") +
      ((path) ? "; path=" + path : "") +
      ((domain) ? "; domain=" + domain : "") +
      ((secure) ? "; secure" : "");
  document.cookie = curCookie;
}

function ob_nodeEnsureVisible(ob_od)
{
	tree = document.getElementById(ob_tree_id);
	if (!tree.style.pixelWidth) tree.style.pixelWidth = eval(tree.style.width.replace('px', ''));
	if (!tree.style.pixelHeight) tree.style.pixelHeight = eval(tree.style.height.replace('px', ''));
	
	topPos = (ob_getTop(ob_od) - ob_getTop(tree) - tree.scrollTop);
	bottomPos = topPos + ob_od.offsetHeight;
	leftPos = (ob_getLeft(ob_od) - ob_getLeft(tree) - tree.scrollLeft);
	rightPos = leftPos + ob_od.offsetWidth;

	dif = bottomPos - tree.style.pixelHeight + 1;
	if (topPos < 0) tree.scrollTop += topPos;
	else if (dif > 0) tree.scrollTop += dif;
	
	dif = rightPos - tree.style.pixelWidth + 1;
	if (leftPos < 0) tree.scrollLeft += leftPos;
	else if (dif > 0) tree.scrollLeft += dif;
	
	dif1 = (topPos + ob_getTop(tree)) - document.body.scrollTop;
	dif2 = (ob_getTop(tree) + bottomPos) - (document.body.clientHeight + document.body.scrollTop) + 1;
	if (dif1 < 0) document.body.scrollTop += dif1;
	else if (dif2 > 0) document.body.scrollTop += dif2;
}

function ob_getLeft(obj){
    var pos = 0;
    if (obj.offsetParent) {
        while (obj.offsetParent) {
            pos += obj.offsetLeft;
            obj = obj.offsetParent;
        }
    }
    else if (obj.x)
        pos += obj.x;
    return pos;
}

function ob_getTop(obj){
    var pos = 0;
    if (obj.offsetParent) {
        while (obj.offsetParent) {
            pos += obj.offsetTop;
            obj = obj.offsetParent;
        }
    }
    else if (obj.y)
        pos += obj.y;
    return pos;
}
//-->














