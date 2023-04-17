<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
 <HEAD>
  <TITLE> New Document </TITLE>
  <META NAME="Generator" CONTENT="EditPlus">
  <META NAME="Author" CONTENT="">
  <META NAME="Keywords" CONTENT="">
  <META NAME="Description" CONTENT="">
 </HEAD>
 <BODY>
  
<script src="/sys_util/ckeditor_ASP/ckeditor.js"></script>  
<script>  
    var editor;  
    CKEDITOR.on( 'instanceReady', function( ev ) {  
        editor = ev.editor;  
        document.getElementById( 'readOnlyOn' ).style.display = '';  
        editor.on( 'readOnly', function() {  
            document.getElementById( 'readOnlyOn' ).style.display = this.readOnly ? 'none' : '';  
            document.getElementById( 'readOnlyOff' ).style.display = this.readOnly ? '' : 'none';  
        });  
    });  
</script>  
<script>  
if(editor.getData() == ""){  
    alert("내용을 입력하세요");  
    return false;  
}  
</script> 
  
<textarea id="contents" name="contents"></textarea>
<script type="text/javascript">
   CKEDITOR.replace('contents');
</script>
 

 </BODY>
</HTML>
