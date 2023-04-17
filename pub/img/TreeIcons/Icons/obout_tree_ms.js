
// variable used to store all selected nodes
var ob_sn2 = "";

function ob_multiselect(ob_od, ev)
{
	if (ob_od.id == "") return;

	if (!ev) ev = window.event;
	if (!ev) return;

	var ctrlPressed = false;
	if (ev != null) ctrlPressed = ev.ctrlKey;

	// If the CTRL key was not pressed, deselect all selected nodes
	if (ctrlPressed == 0)
	{
		// to see if we're looking at the correct element
 		if(ob_od.id != "") 
		{
			ob_unselectAllNodes();

			// Assign new selected node id to ob_sn2
			ob_sn2 = ob_od.id;

			// if we have a record of the last selected node
			if (typeof ob_op2 != "undefined") 
			{
				// we de-select it (also setting the parent table background color to transparent
				ob_op2.className = "ob_t2";
				ob_op2.parentNode.parentNode.parentNode.style.backgroundColor = "transparent";
			}

			ob_od.className = "ob_t3";
		}
	}
	 // If CTRL was pressed while clicking, we append the newly selected nodeID to ob_sn2
	else
	{
		// we have to check whether the node is already selected or not
		// we create an array of all elements currently selected
		var boxArray
		boxArray = ob_sn2.split("|")
		boxArrayLength = boxArray.length
	
		// if it has elements
		if(boxArrayLength > 0)
		{
			// this is the index in the array of the element currently being selected
			ob_ioc = -1;
			
			// we search for current element in the array
			for (i=0; i < boxArrayLength; i++)
			{
				// and if we find it, we assign it's index to ob_ioc
				if (boxArray[i] == ob_od.id) 
				{
					ob_ioc = i;
					break;
				}
			}
			
			// if the element was found
			if (ob_ioc > -1)
			{
				// we remove it from the array
				boxArray.splice(ob_ioc, 1);
				// if we still have elements in the array
				if (boxArray.length > 0)
				{
					// we assigned as last selected node the element found at the last index of the array
					tree_selected_id = boxArray[boxArray.length-1];
					ob_op2 = eval("document.getElementById('" + boxArray[boxArray.length-1] + "')");
				}
				else
				{
					// else we set the last selected node to undefined
					tree_selected_id = "";
					ob_op2 = undefined;
				}
				
				// we recreate ob_sn2 from what is left of the boxArray
				ob_sn2 = boxArray.join("|");
				
				// we set the curent node's class name to that of a de-selected node
				ob_od.className = "ob_t2";
       					
       			// we select the parent table in order to have its background set to
       			// transparent - meaning we deselect the node
	       		myEl2 = ob_od.parentNode.parentNode.parentNode;
       			myEl2.style.backgroundColor = 'transparent';
       			
       			// we exit the function - continuing would mean we allow the node's selection
       			return;
			}
			else
			{
				// if the node was not found, we add it to ob_sn2 and allow the execution
				// to continue with the selection of the node
				if(ob_od.id != "") ob_sn2 += ((ob_sn2.length > 0) ? "|" : "") + ob_od.id;
			}
		}
 	}
}

function ob_unselectAllNodes ()
{
	try
	{
		// If there's no list of the selected nodes, return without doing anything
		if (typeof(ob_sn2) == 'undefined') return;
	
		// Assign all previously selected nodes to prev_sn2  	
		var prev_sn2 = "";
		if (typeof ob_sn2 != "undefined") prev_sn2 = ob_sn2;
		
		// Split the "|" to create an array from all the previously selected values in ob_sn2
		var boxArray;
		if(prev_sn2.length > 0) 
		{
			// If there are more than one selected node, there will be a "|" in the prev_sn2
			if(prev_sn2.indexOf("|") > -1)
			{
				boxArray = prev_sn2.split("|")
				boxArrayLength = boxArray.length;

				// if it has elements
				if(boxArrayLength > 0)
				{
					var i=0; 
					var el;
						
					for (i=0; i<boxArrayLength; i++) 
					{ 
						// el gets to be each element in ob_sn2
						el = eval("document.getElementById('" + boxArray[i] + "')");
						// we set its class name to that of a de-selected node
						el.className = "ob_t2";
	       			
       					// we select the parent table in order to have its background set to
       					// transparent - meaning we deselect the node
	       				myEl2 = el.parentNode.parentNode.parentNode;
       					myEl2.style.backgroundColor = 'transparent';
					}
				}
			}
		}
	}
	catch(e) {}
}














