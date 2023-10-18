function pollAction(el) {
    const action = el.innerText.toLowerCase();
    const pollID = +el.getAttribute('pollid');

    document.querySelector('#txtOperation').value = action;
    document.querySelector('#txtId').value = pollID;
    
    document.querySelector('#pollHiddenSubmit').click();
}