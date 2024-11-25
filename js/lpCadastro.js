document.getElementById('contactForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('/processar_formulario.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                var myModal = new bootstrap.Modal(document.getElementById('successModal'));
                myModal.show();

                setTimeout(function () {
                    location.reload();
                }, 3000);
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            alert("Houve um problema com o envio do formulário. Tente novamente.");
        });
});
