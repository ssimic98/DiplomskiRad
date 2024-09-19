document.addEventListener('DOMContentLoaded',function()
{
    const csrfToken=document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.querySelectorAll('.favorite-icon').forEach(icon=>
    {
        icon.addEventListener('click',function(event)
        {
            event.preventDefault();

            const dogId=this.getAttribute('data-dog-id');
            const iconElement=this.querySelector('i');
            const isFavorited=iconElement.classList.contains('fa-solid');
 
            fetch('/user/favorite-dog',{
                method:isFavorited ? 'DELETE':'POST',
                headers:{
                    'Content-Type':'application/json',
                    'X-CSRF-TOKEN':csrfToken
                },
                body:JSON.stringify({dog_id:dogId})
            }).then(response=>response.json())
            .then(data=> 
            {
                if(data.success)
                {
                    if(isFavorited)
                    {
                        iconElement.classList.remove('fa-solid','fa-heart');
                        iconElement.classList.add('fa-regular','fa-heart');
                    }
                    else
                    {
                        iconElement.classList.remove('fa-regular','fa-heart');
                        iconElement.classList.add('fa-solid','fa-heart');
                    }
                }
                else
                {
                    console.error("Failed to update data status");
                }
            }).catch(error=>console.error("Error:",error))
        });
    });
});