//**********Delete Function*******************/




$(".delete_button").click(function() {

    return confirm("Are you sure you want to delete this item?");

});

$(".deletecomposition_button").click(function() {

    return confirm("Are you sure you want to delete this Composition?");

});

$(".deletebook_button").click(function() {

    return confirm("Are you sure you want to delete this Book?");

});

$(".deleteEditor_button").click(function() {

    return confirm("Are you sure you want to delete this Editor?");

});

$(".deleteComposer_button").click(function() {

    return confirm("Are you sure you want to delete this Composer?");

});

$(".deleteArranger_button").click(function() {

    return confirm("Are you sure you want to delete this Arranger?");

});

$(".deleteLyricist_button").click(function() {

    return confirm("Are you sure you want to delete this Lyricist?");

});

$(".deletePublisher_button").click(function() {

    return confirm("Are you sure you want to delete this Publisher?");

});




/*Generic function we can use for every auto complete instance*/

function listener(elementID,  fullListArray, ulID) {
    document.getElementById(elementID).addEventListener('input', (e) => {
        let matchesArray = [];

        if (e.target.value) {
            var target_value = e.target.value.replace(/\'/g, "&#039");
            matchesArray = fullListArray.filter(item => item.toLowerCase().includes(target_value.toLowerCase()));
            matchesArray = matchesArray.map(item => `<li><a href="#" onclick="stuffValue(this, '${elementID}', '${ulID}');return false;">${item}</a></li>`);
        }
        showArray(matchesArray);
    });

    function showArray(matchesArray) {
        const html = !matchesArray.length ? '' : matchesArray.join('');
        document.getElementById(ulID).innerHTML = html;
    }

} /*End listener Function*/

function stuffValue(link, textBoxId, ulID) {
    var newValue = link.text;
    document.getElementById(textBoxId).value = newValue;
    document.getElementById(ulID).innerHTML = '';
}














