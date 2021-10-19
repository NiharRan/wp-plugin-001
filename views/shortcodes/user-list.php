<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="flex py-3 items-center justify-start">
                <p class="text-2xl font-bold mr-3">Users</p>
                <a class="px-4 py-2 bg-blue-600 text-white font-bold rounded-md hover:text-white hover:bg-blue-500 transition-all delay-300 ease-in-out" href="/user-create-form/?action=create">Add New</a>
            </div>
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th></th>
                            <th>
                                <input type="text" name="name" id="name" placeholder="Search By Name">
                            </th>
                            <th>
                                <input type="text" name="email" id="email" placeholder="Search By Email">
                            </th>
                            <th>
                                <select name="status" id="status">
                                    <option value="">Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </th>
                            <th>
                                <select name="role" id="role">
                                    <option value="">Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="customer">Customer</option>
                                    <option value="user">User</option>
                                </select>
                            </th>
                            <th></th>
                        </tr>
                        <tr>
                            <th>
                                <input type="checkbox" name="ids[]" id="all-selector">
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Title
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Role
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <button id="delete-multiple-btn" class="hidden px-2 py-1 bg-red-600 text-white font-bold rounded-md hover:text-white hover:bg-red-500 transition-all delay-300 ease-in-out">Delete All</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="user-list">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        const user_list = $("#user-list");
        const name_field = $("#name");
        const email_field = $("#email");
        const role_field = $("#role");
        const status_field = $("#status");

        const fetch_users = async function() {
            let name = name_field ? name_field.val() : '';
            let email = email_field ? email_field.val() : '';
            let role = role_field ? role_field.val() : '';
            let status = status_field ? status_field.val() : '';

            const response = await $.ajax({
                url: '/wp-json/wp-vue/v1/users',
                type: "GET",
                data: {
                    name,
                    email,
                    role,
                    status
                },
                dataType: "JSON"
            });

            let output = '';
            if (response) {
                $.each(response, function(key, row) {
                    output += `<tr>
                                <td>
                                    <input type="checkbox" class="row-id" data-id="${row.id}">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    ${row.name}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    ${row.email}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${row.status == 1
                                                                                                                    ? 'bg-green-100 text-green-800'
                                                                                                                    : 'bg-red-100 text-red-800'
                                    }">
                                        ${row.status == 1 ? "Active" : "Inactive"}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ${row.role}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="/user-create-form/?action=edit&id=${row.id}/${row.id}" class="px-4 py-2 bg-purple-600 text-white font-bold rounded-md hover:text-white hover:bg-purple-500 transition-all delay-300 ease-in-out">Edit</a>
                                </td>
                            </tr>`;
                });
            }
            if (user_list) {
                user_list.html(output);
            }
        }
        fetch_users();
        if (name_field) {
            name_field.keyup(function(e) {
                fetch_users();
            });
        }
        if (email_field) {
            email_field.keyup(function(e) {
                fetch_users();
            });
        }
        if (role_field) {
            role_field.change(function(e) {
                fetch_users();
            });
        }
        if (status_field) {
            status_field.change(function(e) {
                fetch_users();
            });
        }



        const delete_btn = $("#delete-multiple-btn");


        function has_selected() {
            let flag = false;
            let eles = $(".row-id");
            $.each(eles, function(key, el) {
                if ($(el).is(":checked")) {
                    flag = true;
                }
            });

            return flag;
        }


        $("#user-list").on('click', function(e) {
            const el = $(e.target);
            if (el.hasClass("row-id")) {
                if (has_selected()) {
                    delete_btn.removeClass("hidden");
                } else {
                    delete_btn.addClass("hidden");
                }
            }
        })

        $("#all-selector").click(function() {
            let eles = $(".row-id");
            if ($(this).is(":checked")) {
                if (eles) {
                    $.each(eles, function(key, el) {
                        $(el).prop("checked", true);
                    });
                }
                delete_btn.removeClass("hidden");
            } else {
                if (eles) {
                    $.each(eles, function(key, el) {
                        $(el).prop("checked", false);
                    });
                }
                delete_btn.addClass("hidden");
            }
        });


        delete_btn.click(function() {
            let eles = $(".row-id");
            var ids = [];
            if (eles) {
                $.each(eles, function(key, el) {
                    if ($(el).is(":checked")) {
                        ids[key] = $(el).data("id");
                    }
                })
            };
            if (ids.length > 0) {
                $.ajax({
                    url: '/wp-json/wp-vue/v1/users',
                    type: "DELETE",
                    data: {
                        id: ids
                    },
                    dataType: "JSON",
                    success: function(response) {
                        location.reload()
                    }
                })
            }
        });
    });
</script>