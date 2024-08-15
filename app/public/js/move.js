const openAddButton = document.querySelectorAll('[data-modal-target]');
const closeAddButton = document.querySelectorAll('[data-close-button]');

const overlay = document.getElementById('overlay');
openAddButton.forEach(button => {
    button.addEventListener('click', (event) => {
        event.preventDefault()
    const button = event.currentTarget;
    const add = document.querySelector(button.dataset.modalTarget);
    openModal(add);
    });
})
closeAddButton.forEach(button => {
    button.addEventListener('click', (event) => {
    const button = event.currentTarget;
    const add = button.closest('.modal');
    closeModal(add);
    });
})
function openModal(modal){
    if(modal === null) return;
    modal.classList.add('active');
    overlay.classList.add('active');
}



function closeModal(modal){
    if(modal == null) return;
    modal.classList.remove('active');
    overlay.classList.remove('active');
}

function checkURL(abc){
	var string = abc.value
	if(!~string.indexOf("http")){
		string = "http://"+string
	}
	abc.value = string
	return abc
}