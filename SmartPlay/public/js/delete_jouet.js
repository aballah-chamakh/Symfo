const jouets = document.getElementById("jouet-liste-container") ;
if(jouets){
    jouets.addEventListener('click',e=>{
        if(e.target.className === 'btn btn-primary delete-jouet-btn'){
            let code_jouet = e.target.getAttribute("data-code-jouet") ;
            fetch("/jouet/"+code_jouet+"/delete",{
                method : "DELETE" ,
            }).then(res=>{
                
                res.json().then((data) => {
                    let ligne_cdes_count = data["ligne_cdes_count"] ;
                    if(ligne_cdes_count == 0){
                        window.location.reload() ;
                    }else{
                        alert("impossible de supprimer ce jouet")
                    }
                
                });
            })               
        }

    })
}