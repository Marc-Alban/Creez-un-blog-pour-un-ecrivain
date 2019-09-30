$(document).ready(function () {

  var name = document.getElementById("name");
  if (name) {
    name.addEventListener("input", function (e) {
      var name = e.target.value; // Valeur saisie dans le champ name
      var longueurName = "faible";
      var couleurMsg = "red"; // Longueur faible => couleur rouge
      if (name.length >= 8) {
        longueurName = "suffisante";
        couleurMsg = "green"; // Longueur suffisante => couleur verte
      } else if (name.length >= 4) {
        longueurName = "moyenne";
        couleurMsg = "orange"; // Longueur moyenne => couleur orange
      }
      var aideNameElt = document.getElementById("aideName");
      aideNameElt.textContent = "Longueur : " + longueurName; // Texte de l'aide
      aideNameElt.style.color = couleurMsg; // Couleur du texte de l'aide
    });
  }

});