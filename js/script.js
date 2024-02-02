var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");
btnclose = document.getElementById("btnClose");
bouton_confirmer = document.getElementById("bouton_envoyer")

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
console.log(btn)
btn.onclick = function() {
  modal.style.display = "block";
  bouton_confirmer.value = btn.value;
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}


function afficher_modal(id){
	var btn_appuyer = document.getElementById('myBtn'+id)
	bouton_confirmer = document.getElementById("bouton_envoyer")
	var modal = document.getElementById("myModal");

	modal.style.display = "block";
	bouton_confirmer.value = btn_appuyer.value;

}

function fermeture(){
	var modal = document.getElementById("myModal");
	modal.style.display = "none";


}