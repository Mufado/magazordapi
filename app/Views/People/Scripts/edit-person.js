document.addEventListener("DOMContentLoaded", function () {
  let form = document.getElementById("form");

  form.addEventListener("submit", function (e) {
    e.preventDefault();
    var formData = new FormData(form);
    var jsonData = {};

    formData.forEach(function (value, key) {
      jsonData[key] = value;
    });

    makeRequest("POST", "People/editPerson", jsonData)
      .then(function (response) {
        window.location.replace("?page=People");
        return response.text();
      })
      .then(function (data) {
        console.log(data);
      });
  });
});

function makeRequest(type, action, data = null) {
  return fetch("index.php", {
    method: type,
    headers: {
      "Content-Type": "application/json; charset=utf-8",
      "X-Action": action,
    },
    body: type === "GET" ? null : JSON.stringify(data),
  });
}
