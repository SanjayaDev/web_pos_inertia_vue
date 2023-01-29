<template>
    <Head>
        <title>Permissions - Aplikasi Kasir</title>
    </Head>

    <LayoutApp>
      <main class="c-main">
          <div class="container-fluid">
              <div class="fade-in">
                  <div class="row">
                      <div class="col-md-12">
                          <div
                              class="card border-0 rounded-3 shadow border-top-purple"
                          >
                              <div class="card-header">
                                  <span class="font-weight-bold"
                                      ><i class="fa fa-key"></i> PERMISSIONS</span
                                  >
                              </div>
                              <div class="card-body">
                                  <form @submit.prevent="handleSearch">
                                      <div class="input-group mb-3">
                                          <input
                                              type="text"
                                              class="form-control"
                                              placeholder="search by permission name..."
                                              v-model="search"
                                          />
                                          <button
                                              class="btn btn-primary input-group-text"
                                              type="submit"
                                          >
                                              <i class="fa fa-search me-2"></i>
                                              SEARCH
                                          </button>
                                      </div>
                                  </form>
                                  <table
                                      class="table table-striped table-bordered table-hover"
                                  >
                                      <thead>
                                          <tr>
                                              <th scope="col">Permission Name</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr
                                              v-for="(
                                                  permission, index
                                              ) in permissions.data"
                                              :key="index"
                                          >
                                              <td>{{ permission.name }}</td>
                                          </tr>
                                      </tbody>
                                  </table>
                                  <Pagination
                                      :links="permissions.links"
                                      align="end"
                                  />
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </main>
    </LayoutApp>
</template>

<script setup>
import LayoutApp from "../../../Layouts/App.vue";
import Pagination from "../../../Components/Pagination.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
  permissions: Object
});

const search = ref("" ||(new URL(document.location)).searchParams.get('q'));
const handleSearch = () => {
  Inertia.get("/apps/permissions", {
    q: search.value
  });
}
</script>