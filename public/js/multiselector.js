
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