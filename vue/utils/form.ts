/**
 * Wysiwyg editor config
 * 
 * @returns 
 */
export const _editorInit = () => {
    return {
        height: '500px',
        width: '100%',
        menu: {
            favs: {title: 'My Favorites', items: 'code visualaid | searchreplace'}
        },
        menubar: 'favs file edit view insert format tools table help',
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
        ],
        toolbar:
            'undo redo | formatselect | bold italic underline link | \
            alignleft aligncenter alignright alignjustify | \
            bullist numlist outdent indent | removeformat | help'
    }
}