
Trex.I.Processor.WebkitBR = {
	changeAlign: function(attributes) {	// Align
	 	var  cmd;
		switch(attributes.style.textAlign){ 
			case "left" : cmd = "justifyleft"; break;
			case "center": cmd = "justifycenter"; break;
			case "right" : cmd = "justifyright"; break;
			case "justify" : cmd = "justifyfull"; break;
		}
		this.execCommand(cmd );
	}
};

