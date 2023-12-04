function deleteContact(e) {
  let jsonData = { id: e.target.parentNode.parentNode.getAttribute("data-id") };

  makeRequest("POST", "Contacts/deleteContact", jsonData)
    .then(function (response) {
      window.location.replace("?page=Contacts");
      return response.text();
    })
    .then(function (data) {
      console.log(data);
    });
}

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
