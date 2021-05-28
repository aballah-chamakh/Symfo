const commandes = document.getElementById("commande-liste-container") ;
if(commandes){
    commandes.addEventListener('click',e=>{
        if(e.target.className === 'btn btn-primary delete-commande-btn'){
            let num_cde = e.target.getAttribute("data-num-cde") ;
            fetch("/commande/"+num_cde+"/delete",{
                method : "DELETE" ,
            }).then(res=>{
                window.location.reload() ;
                });              
        }

    })
}