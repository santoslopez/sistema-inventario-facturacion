//valida la caja de texto para que permita solo numeros y un maximo de 2 decimales
function validateNumberInput(inputId) {
    const input = document.getElementById(inputId);
    const pattern = /^\d+(?:\.\d{0,2})?$/;
    input.addEventListener("input", function (event) {
      if (!pattern.test(input.value)) {
        input.value = input.value.slice(0, -1);
      }
    });
}

function validarDocumentoProveedor(inputId) {
    // valida que solo se ingresen letras y numeros, guion bajo, guion normal
    const input = document.getElementById("inputDocumentoProveedor");
    const pattern = /^[a-zA-Z0-9_-]+$/;
  
    input.addEventListener("input", function (event) {
      if (!pattern.test(input.value)) {
        input.value = input.value.slice(0, -1);
      }
    });
  }

  