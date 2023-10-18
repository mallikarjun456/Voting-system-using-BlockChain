function userAction(el) {
    const action = el.innerText.toLowerCase();
    const userid = +el.getAttribute('userid');

    document.querySelector('#txtOperation').value = action;
    document.querySelector('#txtId').value = userid;
    
    document.querySelector('#userHiddenSubmit').click();
}