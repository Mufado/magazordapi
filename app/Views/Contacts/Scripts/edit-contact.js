function updateContact() {
  var contactType = document.getElementById("contactType").value;
  var contactDescription = document.getElementById("contactDescription").value;
  var personId = document.getElementById("personId").value;

  fetch("backend_update_contact.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      contactType: contactType,
      contactDescription: contactDescription,
      personId: personId,
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log("Resposta do servidor:", data);
      alert("Contato atualizado com sucesso!");
    })
    .catch((error) => {
      console.error("Erro:", error);
      alert("Ocorreu um erro ao atualizar o contato.");
    });
}
