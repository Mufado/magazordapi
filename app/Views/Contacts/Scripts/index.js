function processEvent(e, type) {
  switch (type) {
    case "delete":
      deleteContact(e);
      break;
    case "edit":
      editContact(e);
      break;
    case "search":
      searchContacts(e);
    default:
      break;
  }
}

function searchContacts(e) {
  e.preventDefault();

  fetch(
    "?page=Contacts&cb=searchContacts&txt=" +
      encodeURIComponent(e.target.getElementsByTagName("input")[0].value)
  )
    .then(function (response) {
      return response.text();
    })
    .then(function (data) {
      document.documentElement.innerHTML = data;
    });
}

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

function editContact(e) {
  let id = e.target.parentNode.parentNode.getAttribute("data-id");
  window.location.replace("?page=Contacts&cb=goToEditContactPage&id=" + id);
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
