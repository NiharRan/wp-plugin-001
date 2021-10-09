<template>
  <div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="flex py-3 items-center justify-start">
          <p class="text-2xl font-bold mr-3">Users</p>
          <router-link
            class="px-4 py-2 bg-blue-600 text-white font-bold rounded-md hover:text-white hover:bg-blue-500 transition-all delay-300 ease-in-out"
            to="/create"
            >Add New</router-link
          >
        </div>
        <div
          class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg"
        >
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Name
                </th>
                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Title
                </th>
                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Status
                </th>
                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Role
                </th>
                <th scope="col" class="relative px-6 py-3">
                  <span class="sr-only">Edit</span>
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="person in users" :key="person.email">
                <td class="px-6 py-4 whitespace-nowrap">
                  {{ person.name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  {{ person.email }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span
                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                    :class="[
                      person.status == 1
                        ? 'bg-green-100 text-green-800'
                        : 'bg-red-100 text-red-800',
                    ]"
                  >
                    {{ person.status == 1 ? "Active" : "Inactive" }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ person.role }}
                </td>
                <td
                  class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                >
                  <router-link
                    :to="`/edit/${person.id}`"
                    class="px-4 py-2 bg-purple-600 text-white font-bold rounded-md hover:text-white hover:bg-purple-500 transition-all delay-300 ease-in-out"
                    >Edit</router-link
                  >
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  data: function() {
    return {};
  },
  computed: {
    ...mapGetters(["users", "changed", "message"]),
  },
  created() {
    if (this.changed) {
      this.$toast(this.message, "success");
      this.$store.dispatch("CHANGED_ACTION", false);
    }
    this.$store.dispatch("FETCH_USERS");
  },
};
</script>
