function deletePerson(e) {
  let jsonData = { id: e.target.parentNode.parentNode.getAttribute("data-id") };

  makeRequest("POST", "People/deletePerson", jsonData)
    .then(function (response) {
      return response.text();
    })
    .then(function (data) {
      console.log(data);
    });

  fetch("a/??gdfsgfdsafsadHome&cd=index");
}

function makeRequest(type, action, data = null) {
  return fetch("index.php/?page=Contact", {
    method: type,
    headers: {
      "Content-Type": "application/json; charset=utf-8",
      "X-Action": action,
    },
    body: type === "GET" ? null : JSON.stringify(data),
  });
}
