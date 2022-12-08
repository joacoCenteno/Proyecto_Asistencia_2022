const consulta = fetch('https://apis.datos.gob.ar/georef/api/localidades?departamento=10091&campos=id,nombre&max=100')
    // Exito
    .then(response => response.json())  // convertir a json
    .then(data => {
        const elemento = document.getElementById('lista');
         
         
         for(let i= 0; i<= data.localidades.length; i++)
         {
            
            elemento.innerHTML += `
            <option value="${data.localidades[i].id}" >${data.localidades[i].nombre}</option>
            `;
           
         }

    }) 
    .catch(err => console.log('Solicitud fallida', err)); // Capturar errores


document.getElementById('radio_comunidad').addEventListener('click', ()=>{
    document.getElementById('comunidad_input').removeAttribute('disabled');
});

document.getElementById('radio_comunidad_false').addEventListener('click', ()=>{
    document.getElementById('comunidad_input').setAttribute('disabled', 'disabled');
});
