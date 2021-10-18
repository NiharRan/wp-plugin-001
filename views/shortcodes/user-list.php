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
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($users as $person) { ?>
                            <tr v-for="person in users">
                                <td>
                                    <input type="checkbox" class="person-id" data-id="<?php echo $person->id; ?>">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php echo $person->name; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php echo $person->email; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $person->status == 1
                                                                                                                    ? 'bg-green-100 text-green-800'
                                                                                                                    : 'bg-red-100 text-red-800'
                                                                                                                ?>">
                                        <?php echo $person->status == 1 ? "Active" : "Inactive" ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo $person->role ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="/user-create-form/?action=edit&id=<?php echo $person->id; ?>/<?php echo $person->id; ?>" class="px-4 py-2 bg-purple-600 text-white font-bold rounded-md hover:text-white hover:bg-purple-500 transition-all delay-300 ease-in-out">Edit</a>
                                </td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        const eles = $(".person-id");
        const delete_btn = $("#delete-multiple-btn");


        function has_selected() {
            let flag = false;
            $.each(eles, function(key, el) {
                if ($(el).is(":checked")) {
                    flag = true;
                }
            });

            return flag;
        }


        if (eles) {
            $.each(eles, function(key, el) {
                $(el).click(function() {
                    if (has_selected()) {
                        delete_btn.removeClass("hidden");
                    } else {
                        delete_btn.addClass("hidden");
                    }
                });
            });
        }

        $("#all-selector").click(function() {
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