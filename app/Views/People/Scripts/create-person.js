let form = document.getElementById("form");

form.addEventListener("submit", function (e) {
  var formData = new FormData(form);
  var jsonData = {};

  formData.forEach(function (value, key) {
    jsonData[key] = value;
  });

  makeRequest("POST", "People/createPerson", jsonData)
    .then(function (response) {
      makeRequest("GET", "?page=People");
      return response.text();
    })
    .then(function (data) {
      console.log(data);
    });
});

function makeRequest(type, action, data = null) {
  return fetch("index.php?page=People", {
    method: type,
    headers: {
      "Content-Type": "application/json; charset=utf-8",
      "X-Action": action,
    },
    body: type === "GET" ? null : JSON.stringify(data),
  });
}
