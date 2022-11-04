import UIkit from 'uikit';

UIkit.util.on('#js-modal-confirm', 'click', function (e) {
    e.preventDefault();
    e.target.blur();
    UIkit.modal.confirm('UIkit confirm!').then(function () {
        console.log('Confirmed.')
    }, function () {
        console.log('Rejected.')
    });
});