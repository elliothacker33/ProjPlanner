function resetAll(){
    const multiselectors = document.querySelectorAll('.multiselector');
    multiselectors.forEach((multiselector) =>{
        const dropdown = multiselector.querySelector('.dropdown');
        if(!dropdown.classList.contains('hidden')){
            dropdown.classList.add('hidden');
            const icon = multiselector.querySelector('span i.fas');
            icon.classList.toggle('fa-chevron-down')
        }
    });
}
export function config_multiselector(){
    const multiselectors = document.querySelectorAll('.multiselector');
    multiselectors.forEach((multiselector) =>
        multiselector.querySelector('span').addEventListener('click' ,(e)=>{
            const dropdown = multiselector.querySelector('.dropdown');
            if(dropdown.classList.contains('hidden')) resetAll();
            const icon = multiselector.querySelector('span i.fas');
            icon.classList.toggle('fa-chevron-down')
            dropdown.classList.toggle('hidden');
        }

    ))

}

export function multiselector(origin, destany){
    const items = document.querySelectorAll(origin+' .multiselector .item input:checked');
    const values=[];
    for (let idx =0;  idx < items.length; idx++){
        values[idx] = parseInt(items[idx].value);
    }
    console.log(values);
    const destanyInput = document.querySelector(destany);
    destanyInput.value = values;
}