

function check_radio(){
	
	if(document.newWrite_form.boardtype.value.length==0){
		newWrite_form.boardtype.focus();
		return false;
	}
	if(document.newWrite_form.username.value.length==0){
		newWrite_form.username.focus();
		return false;
	}
	if(!radio_1.checked && !radio_2.checked && !radio_3.checked){
		alert('분류를 하나 이상 선택하세요.');
		newWrite_form.radio_1.focus();
		return false;
	}
	if(document.newWrite_form.title.value.length==0){
		newWrite_form.title.focus();
		return false;
	}
	if(document.newWrite_form.content.value.length==0){
		newWrite_form.content.focus();
		return false;
	}
	return true;
}