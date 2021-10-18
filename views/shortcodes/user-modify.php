<form id="<?php echo $action; ?>">
    <div class="mb-4">
        <label class="mb-2 font-bold" for="name">Name</label>
        <input type="text" value="<?php echo $user ? $user->name : '' ?>" name="name" class="w-full" placeholder="Your Name" />
    </div>
    <div class="mb-4">
        <label class="mb-2 font-bold" for="email">E-mail</label>
        <input type="email" class="w-full" value="<?php echo $user ? $user->email : '' ?>" name="email" placeholder="Your E-mail Address" />
    </div>
    <div class="mb-4">
        <label class="mb-2 font-bold" for="role">Role</label>
        <select v-model="formData.role" class="w-full min-w-full" name="role">
            <option value="">Select ...</option>
            <option value="admin" <?php echo ($user && $user->role == 'admin') ? 'selected' : '' ?>>Admin</option>
            <option value="user" <?php echo ($user && $user->role == 'user') ? 'selected' : '' ?>>User</option>
        </select>
    </div>
    <?php if ($action == 'edit') { ?>
        <div class="mb-4">
            <label class="mb-2 font-bold">Status</label>
            <select name="status" class="w-full min-w-full">
                <option value="">Select ...</option>
                <option value="1" <?php echo ($user && $user->status == 1) ? 'selected' : '' ?>>Active</option>
                <option value="0" <?php echo ($user && $user->status == 0) ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>
    <?php } ?>
    <div>
        <input type="hidden" name="id" value="<?php echo $user ? $user->id : ''; ?>">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-bold rounded-md hover:text-white hover:bg-blue-500 transition-all delay-300 ease-in-out">
            <?php echo $action == "create" ? "Store" : "Update" ?>
        </button>
    </div>
</form>


<script>
    jQuery(document).ready(function($) {
        $("#create").submit(function(e) {
            e.preventDefault();
            const data = $(this).serialize();

            $.ajax({
                url: '/wp-json/wp-vue/v1/users',
                type: 'POST',
                data: data,
                dataType: 'JSON',
                success: function(response) {
                    if (response) {
                        window.location.href = '/sample-page';
                    }
                }
            });
        })

        $("#edit").submit(function(e) {
            e.preventDefault();
            const data = $(this).serialize();

            $.ajax({
                url: '/wp-json/wp-vue/v1/users',
                type: 'PUT',
                data: data,
                dataType: 'JSON',
                success: function(response) {
                    if (response) {
                        window.location.href = '/sample-page';
                    }
                }
            });
        })
    });
</script>