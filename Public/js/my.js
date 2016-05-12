
window.onload=function(){
	var oForm=document.forms[0];
	//检查表格是否可以提交
	oForm.send.onclick=function(){
		if(oForm.content.value==''){
			alert('必须输入内容！');
			oForm.content.focus();
			return false;
		}
	}
}