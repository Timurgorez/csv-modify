



console.log('dfgsdffgds');


if(document.querySelector('.loading')){
    document.querySelector('.loading').addEventListener('click', function (e) {
        setTimeout(function () {
            if(!document.querySelector('.has-error')){
                document.querySelector('.loader').style.display = 'flex';
            }
        },300)

    })
}





