let form = document.getElementById("form");

form.addEventListener("submit", function (e) {
  e.preventDefault();

  var formData = new FormData(form);
  var jsonData = {};

  formData.forEach(function (value, key) {
    jsonData[key] = value;
  });

  fetch("index.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json; charset=utf-8",
      "X-Action": "Home/createPerson",
    },
    body: JSON.stringify(jsonData),
  })
    .then(function (response) {
      return response.text();
    })
    .then(function (data) {
      console.log(data);
    });
});
