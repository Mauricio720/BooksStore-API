document.querySelector('#bookFile').addEventListener('change',(event)=>{
    renderImage(event)
})

function renderImage(e){
    if (!e.target.files) {
        return
    }

    const img = e.target.files[0]
    const fileReader = new FileReader()
    fileReader.readAsDataURL(img)

    fileReader.onload = (event) => {
        const fileUrl = (event.target).result
        document.querySelector('.bookImage img').src=fileUrl;
    }
}