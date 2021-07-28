//https://sharemycode.fr/gn4

var $collectionHolder;
var $boutonAjouter = $('<button type="button" class="add_sport_link">Ajouter sport</button>');
var $nouveau = $('<li></li>').append($boutonAjouter);
jQuery(document).ready(function () {
  $collectionHolder = $('ul.sports');
  $collectionHolder.find('li').each(function () {
    addSportFormDeleteLink($(this));
  });
  $collectionHolder.append($nouveau);
  $collectionHolder.data('index', $collectionHolder.find('input').length);
  $boutonAjouter.on('click', function (e) {
    addSportForm($collectionHolder, $nouveau);
  });

  function addSportForm($collectionHolder, $newLinkLi) {
    var prototype = $collectionHolder.data('prototype');
    var index = $collectionHolder.data('index');
    var newForm = prototype;
    newForm = newForm.replace(/__name__/g, index);
    $collectionHolder.data('index', index + 1);
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
    addSportFormDeleteLink($newFormLi);
  }
  function addSportFormDeleteLink($tagFormLi) {
    var $removeFormButton = $('<button type="button">Supprimer sport</button>');
    $tagFormLi.append($removeFormButton);
    $removeFormButton.on('click', function (e) {
      $tagFormLi.remove();
    });
  }

  //pour supprimer les personnes
  //récupérer les deleteButton et ajouter un écouteur d'évènement
  $('button.deleteBtn').on("click", function (evt) { 
    let url = $(this).data('href');
    console.log(url);
    $.ajax({
      url: url,
      type: 'DELETE',
      success: function(result) {
          // Do something with the result
          document.location.reload();
      }
    });
   })

   $("input.qteProduit").on("change", function (event) {
    const idProduit = $(this).data("id");
    console.log(idProduit);
    const qte = $(this).val();
    console.log(qte);
    if (qte == 0) {
      // supprimer la ligne
      $(this).closest("tr").remove();
    }
    else{
      const prix = $(this).data("prix");
      console.log(prix);
      const tdPrixTotal = $(this).parent().next();
      console.log(tdPrixTotal);
      $(tdPrixTotal).text(prix * qte);
    }
    $.ajax({
      url: "/panier/edit",
      type: 'POST',
      data: {
        id: idProduit,
        quantite: qte
      },
      success: function (result) { // Do something with the result
        // $(tdPrixTotal).text(prix * qte);
        console.log(result);
      },
      error: function (req, status, err) { // Do something with the err
        alert(req);
      }
    });
  });
  //addBtnPanier
  $(".addBtnPanier").on("click", function (event) {
    event.preventDefault();
    //afficher le formulaire
    const quantite = prompt("quantité", 1);
    console.log(quantite);
    const id = $(this).data("id");
    $.ajax({
      url: "/panier/add",
      type: 'POST',
      data: {
        id: id,
        quantite: quantite
      },
      success: function (result) { // Do something with the result
        // $(tdPrixTotal).text(prix * qte);
        console.log(result);
      },
      error: function (req, status, err) { // Do something with the err
        alert(req);
      }
    });
  });

});
