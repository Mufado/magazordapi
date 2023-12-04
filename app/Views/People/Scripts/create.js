function submitForm() {
  console.log("dfsafdsfsdfsdfasd");
  var form = document.getElementById("form");
  var formData = new FormData(form);

  var jsonData = {};

  formData.forEach(function (value, key) {
    jsonData[key] = value;
  });

  fetch("../../../Controllers/PeopleController.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(jsonData),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log("Dados atualizados com sucesso!", data);
    })
    .catch((error) => {
      console.error("Erro durante a requisição:", error);
    });
}
