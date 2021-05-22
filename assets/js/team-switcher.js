$(document).ready(function () {
    let menu = $('.mainmenu-items.mainmenu-extras');
    let switcher = document.createElement('li');
    let button = document.createElement('a');
    let span = document.createElement('span');
    let icon = document.createElement('i');
    let dropdown = document.createElement('ul');

    //
    dropdown.classList.add('dropdown-menu');
    dropdown.setAttribute('role', 'menu');
    dropdown.setAttribute('data-dropdown-title', 'Switch team');

    //
    button.href = 'javascript:;';
    button.setAttribute('data-toggle', 'dropdown');
    button.append(dropdown);
    button.append(span);

    //
    span.append(icon);
    span.classList.add('nav-icon');

    //
    icon.classList.add('icon-building');

    //
    switcher.classList.add('mainmenu-item', 'mainmenu-team-switcher', 'mainmenu-preview', 'dropdown');
    switcher.append(button);
    switcher.append(dropdown);

    //
    menu.prepend(switcher);

    // Load team options
    $.request('onLoadTeamOptions').then(res => {
        res.forEach(function (item) {
            let listItem = document.createElement('li');
            let itemButton = document.createElement('a');

            //
            listItem.setAttribute('role', 'presentation');

            //
            itemButton.innerHTML = item.name;
            itemButton.setAttribute('role', 'menuitem');
            itemButton.setAttribute('tabindex', '-1');
            itemButton.href = 'javascript:;';

            itemButton.setAttribute('data-team', item.code);

            if (item.is_active) {
                itemButton.classList.add('oc-icon-check-circle-o', 'switch-team');
            } else {
                itemButton.classList.add('oc-icon-circle-o', 'switch-team');
            }

            //
            listItem.append(itemButton);

            //
            dropdown.append(listItem);
        });
    });

    //
    $('html').on('click', '.switch-team', function () {
        $.request('onSwitchTeam', {
            data: {
                team_id: $(this).attr('data-team'),
            },
        });
    });
});