$(document).ready(function() {

  var name = document.getElementById("name");
  var comment = document.getElementById("message");
  var aideNameElt = document.getElementById("aideName");
  var couleurMsg = "";

  if (name) {
    name.addEventListener("input", function(e) {
      var name = e.target.value; // Valeur saisie dans le champ name
      var longueurName = "faible";
      couleurMsg = "red"; // Longueur faible => couleur rouge
      if (name.length >= 8) {
        longueurName = "suffisante";
        couleurMsg = "green"; // Longueur suffisante => couleur verte
      } else if (name.length >= 4) {
        longueurName = "moyenne";
        couleurMsg = "orange"; // Longueur moyenne => couleur orange
      }
      aideNameElt.textContent = "Longueur : " + longueurName; // Texte de l'aide
      aideNameElt.style.color = couleurMsg; // Couleur du texte de l'aide
    });
  }

  function hello() {
    alert("hello");
  }

});