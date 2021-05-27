const jouets = document.getElementById("jouet-liste-container") ;
if(jouets){
    jouets.addEventListener('click',e=>{
        if(e.target.className === 'btn btn-primary delete-jouet-btn'){
            let code_jouet = e.target.getAttribute("data-id") ;
            alert("the id is : "+code_jouet) ;
        }

    })
}