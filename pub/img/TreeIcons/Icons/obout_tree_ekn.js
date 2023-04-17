//		Copyright obout inc      http://www.obout.com
//	
//		obout_ASP_TreeView_2      version 2.0.9 

// string containing previous node content
var prevNodeContent;
var tree_edit_id = "";
var inited = false;
tree_node_editing = false;

document.onkeydown = function(e){ob_nodeKeyDown(e)};
if (document.layers) try {document.registerEvents(Event.KEYDOWN)} catch (e) {};

function ob_nodeKeyDown(e)
{
	if (!e) e = window.event;
	
	if (tree_node_editing) return;
	if (document.all)
	{
		e.cancelBubble = true;
		e.returnValue = false;
		if (e.stopPropagation) e.stopPropagation();
	}
	
	// get the selected node
	if (typeof(tree_selected_id) != 'undefined') currentlySelected = document.getElementById(tree_selected_id);
	
	if (typeof(currentlySelected) != 'undefined' && currentlySelected != null)
	{
		// a small little artifice to make the page not scroll in Mozilla
		if (!inited)
		{
			tmptxt = document.createElement("input");
			currentlySelected.appendChild(tmptxt);
			try
			{
				tmptxt.focus();
			}
			catch (e) {}

			currentlySelected.removeChild(tmptxt);
			inited = true;

			e.cancelBubble = true;
			e.returnValue = false;
			if (e.stopPropagation) e.stopPropagation();
		}

		if (typeof(ob_tree_keynav_enable) != 'undefined' && ob_tree_keynav_enable)
		{
			// arrow up
			if (e.keyCode == 38)
			{
				tree_node_exp_col = true;
				prevSibling = ob_getNodeUp(currentlySelected, false);
				if (prevSibling != null) ob_t22(prevSibling);
				tree_node_exp_col = false;
			}
			// arrow down
			else if (e.keyCode == 40)
			{
				tree_node_exp_col = true;
				nxtSibling = ob_getNodeDown(currentlySelected, false);
				if (nxtSibling != null) ob_t22(nxtSibling);
				tree_node_exp_col = false;
			}
			// arrow left
			else if (e.keyCode == 37)
			{
				tree_node_exp_col = true;
				// if the node has children and is expanded, we collapse it
				if (ob_hasChildren(currentlySelected) && ob_isExpanded(currentlySelected))
				{
					currentlySelected.parentNode.firstChild.firstChild.onclick();
				}
				// otherwise we select the parent node
				else
				{
					parentNode = ob_getParentOfNode(currentlySelected);
					if (parentNode != null) ob_t22 (parentNode);
				}
				tree_node_exp_col = false;
			}
			// arrow right
			else if (e.keyCode == 39)
			{
				tree_node_exp_col = true;
				// if the node has children and is collapsed, we expand it
				if (ob_hasChildren(currentlySelected))
				{
					// if the node is colapsed, we expand it
					if(!ob_isExpanded(currentlySelected))
					{
						currentlySelected.parentNode.firstChild.firstChild.onclick();
					}
					// otherwise we select the first child node
					else
					{
						firstChild = ob_getFirstChildOfNode(currentlySelected);
						if (firstChild != null) ob_t22 (firstChild);
					}
				}
				tree_node_exp_col = false;
			}
		}
		if (typeof(ob_tree_editnode_enable) != 'undefined' && ob_tree_editnode_enable)
		{
			// enter or f2 (enter edit mode)
			if (e.keyCode == 13 || e.keyCode == 113)
			{
				// call the selection function again
				ob_t22 (currentlySelected);
			}
		}
	}
}

function ob_textBoxKeyDown(e)
{
	if (!e) e = window.event;

	// get the selected node
	currentlySelected = document.getElementById(tree_selected_id);
	if (currentlySelected != null)
	{
		// if enter was pressed we need to remove the textbox (exit edit mode)
		if (e.keyCode == 13)
		{
			if (currentlySelected.childNodes.length > 0)
			{
				workNode = currentlySelected;
				try
				{
					if (ob_hasChildren(currentlySelected) && currentlySelected.childNodes[0].nodeName.toLowerCase() != "input")
						workNode = currentlySelected.childNodes[0];
				}
				catch (e)
				{
				}
				
				if (workNode.childNodes[0].nodeName.toLowerCase() == "input")
				{
					var name = workNode.childNodes[0].value;
					
					if (name.length == 0 || name.indexOf(':') != -1 || name.indexOf('|') != -1 || name.indexOf(',') != -1 || name.indexOf('<') != -1 || name.indexOf('>') != -1)
					{
						// detach the blur event since upon showing the alert dialog, the blur event will be fired
						currentlySelected.childNodes[0].onblur = null;
						
						// the node name can't be empty or contain invalid characters
						alert('The node name cannot be empty\nand\nIt cannot contain the following characters : | , < >');
						// put the initial name
						workNode.childNodes[0].value = prevNodeContent;
						// focus the textbox
						try
						{
							workNode.childNodes[0].focus();
						}
						catch (e) {}
						// and select the text
						try
						{
							oRange = workNode.childNodes[0].ownerDocument.selection.createRange().duplicate();
							oRange.moveStart("textedit", -1)
							oRange.moveEnd("textedit");
							oRange.select();
						}
						catch (e) {}
						
						// reattach blur event
						workNode.childNodes[0].onblur = function(){ob_textBoxExit(true)};
						
						// mark that we're editing a tree node
						tree_node_editing = true;
					}
					else
					{
						workNode.removeChild(workNode.childNodes[0]);
						workNode.innerHTML = name;
						workNode.className = "ob_t3";

						// if it's different from the initial text, add it to the string containing the modifications
						if (name != prevNodeContent) tree_edit_id += tree_selected_id + ":" + name + "|";
						// mark that we're not editing any tree node
						tree_node_editing = false;
					}
				}
			}

			// stop the propagation of the event (prevent postback and who knows what other events :P)
			e.cancelBubble = true;
			e.returnValue = false;
			if (e.stopPropagation) e.stopPropagation();
		}
		// if escape was pressed we need to remove the textbox (exit edit mode) and restore initial value
		if (e.keyCode == 27)
		{
			ob_textBoxExit(false);
		}
		else
		{
			//alert(e.keyCode);
		}
	}
}

function ob_textBoxExit(keep)
{
	// get the selected node
	currentlySelected = document.getElementById(tree_selected_id);
	if (currentlySelected != null)
	{
		if (currentlySelected.childNodes.length > 0)
		{
			workNode = currentlySelected;
			try
			{
				if (ob_hasChildren(currentlySelected) && currentlySelected.childNodes[0].nodeName.toLowerCase() != "input") workNode = currentlySelected.childNodes[0];
			}
			catch (e)
			{
			}
			
			if (workNode.childNodes[0].nodeName.toLowerCase() == "input")
			{
				var name = workNode.childNodes[0].value;
				workNode.removeChild(workNode.childNodes[0]);
				workNode.innerHTML = keep ? name : prevNodeContent;
				workNode.className = "ob_t3";
				
				if (keep && (name != prevNodeContent)) tree_edit_id += tree_selected_id + ":" + name + "|";
				
				// mark that we're not editing any tree node
				tree_node_editing = false;
			}
		}		
	}
}

function ob_attemptStartEditing(ob_od)
{
	if ((typeof(tree_node_exp_col) == 'undefined' || (typeof(tree_node_exp_col != 'undefined') && !tree_node_exp_col)) &&
		typeof(tree_node_editing) != 'undefined' && typeof(ob_tree_editnode_enable) != 'undefined' && ob_tree_editnode_enable)
	{	

		// if the current node was clicked again
		if (ob_od.id == tree_selected_id)
		{
			// we verify that the node is not in the disabled nodes
			if (typeof (ob_noedit) != "undefined" && ob_noedit != "") 
			{
				var a = new Array;
				a = ob_noedit.replace(" ", "").split(",");
				if (a.length > 0)
				{
					for (i = 0; i < a.length; i++) 
					{
						if (a[i] == ob_od.id) 
						{
							alert("Can't edit. The node is marked as not editable.");
							return;
						}
					}
				}
			}

			// if it has children
			if (ob_od.childNodes.length > 0)
			{
				if (currentlySelected == null) currentlySelected = document.getElementById(tree_selected_id);
				workNode = currentlySelected;
				try
				{
					if (ob_hasChildren(currentlySelected) && currentlySelected.childNodes[0].nodeName.toLowerCase() != "#text")
						workNode = currentlySelected.childNodes[0];
				}
				catch (e)
				{
				}
				
				// if it's text (not a textbox)
				if (workNode.childNodes[0].nodeName.toLowerCase() == "#text")
				{
					// get the current node text
					prevNodeContent = workNode.childNodes[0].nodeValue;
					
					// create the textbox
					var textBox = document.createElement("input");
					
					textBox.setAttribute("type", "text");
					textBox.setAttribute("value", prevNodeContent);
					textBox.id = ob_od.id + "_txtBox";
					textBox.style.borderWidth = 0;
					textBox.style.width = ob_od.offsetWidth+30;
					textBox.style.backgroundColor = "transparent";
					textBox.className = ob_od.className;

					// remove the text currently inside the node
					while (workNode.childNodes.length > 0)
						workNode.removeChild(workNode.childNodes[0]);
					// add the textbox
					workNode.appendChild(textBox);
					// wire the onkeydown event
					textBox.onkeydown = function(e){ob_textBoxKeyDown(e)};
					// wire the onblur event
					textBox.onblur = function(){ob_textBoxExit(true)};
					// focus the textbox
					try
					{
						textBox.focus();
					}
					catch (e) {}

					// select the text currently in the textbox
					try
					{
						oRange = textBox.ownerDocument.selection.createRange().duplicate();
						oRange.moveStart("textedit", -1)
						oRange.moveEnd("textedit");
						if (oRange.htmlText.toLowerCase().indexOf('body') == -1) oRange.select();
						else 
						{
							try
							{
								textBox.focus();
							}
							catch (e) {}
						}
					}
					catch (e) {}

					// mark that we're editing a tree node
					tree_node_editing = true;
				}
			}
		}
	}
}

function ob_attemptEndEditing(ob_od)
{
	currentlySelected = ob_od;
	if (typeof(currentlySelected) != 'undefined' && typeof(tree_node_editing) != 'undefined' && typeof(ob_tree_editnode_enable) != 'undefined' && ob_tree_editnode_enable)
	{	
		workNode = currentlySelected;
		try
		{
			if (ob_hasChildren(currentlySelected) && currentlySelected.childNodes[0].nodeName.toLowerCase() != "input")
				workNode = currentlySelected.childNodes[0];
		}
		catch (e)
		{
		}

		// if it has children
		if (workNode.childNodes.length > 0)
		{
			// if the child is a textbox (was in edit mode)
			if (workNode.childNodes[0].nodeName.toLowerCase() == "input")
			{
				// if it's different than the curent node (was a click in the textbox or in another node)
				if (workNode.id != tree_selected_id)
				{
					// get the current text in the textbox
					var name = workNode.childNodes[0].value;
					// the node name can't be empty or contain invalid characters
					if (name.length == 0 || name.indexOf(':') != -1 || name.indexOf('|') != -1 || name.indexOf(',') != -1 || name.indexOf('<') != -1 || name.indexOf('>') != -1)
					{
						alert('The node name cannot be empty\nand\nIt cannot contain the following characters : | , < >');
						// put the initial name
						workNode.childNodes[0].value = prevNodeContent;
						// focus the textbox
						try
						{
							workNode.childNodes[0].focus();
						}
						catch (e) {}

						// and select the text
						try
						{
							oRange = workNode.childNodes[0].ownerDocument.selection.createRange().duplicate();
							oRange.moveStart("textedit", -1)
							oRange.moveEnd("textedit");
							oRange.select();
						}
						catch(e) {}
						
						// mark that we're editing a tree node
						tree_node_editing = true;
						return;
					}
					// delete the textbox
					workNode.removeChild(workNode.childNodes[0]);
					// write the content to the node as text
					workNode.innerHTML = name;
					// if it's different from the initial text, add it to the string containing the modifications
					if (name != prevNodeContent) tree_edit_id += tree_selected_id + ":" + name + "|";
					// mark that we're not editing any tree node
					tree_node_editing = false;
				}
			}
		}
	}
}














