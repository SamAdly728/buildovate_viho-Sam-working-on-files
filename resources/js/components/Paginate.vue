<template>
  <div class="flex items-center border-t border-gray-300 justify-between bg-white px-4 py-5 sm:px-6">
    <div class="flex flex-1 justify-between sm:hidden">
      <Link :href="prev" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</Link>
      <Link :href="next" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</Link>
    </div>
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
      <div>
        <p class="text-sm text-gray-700">
          Showing
          {{ ' ' }}
          <span class="font-medium">{{ fromRow }}</span>
          {{ ' ' }}
          to
          {{ ' ' }}
          <span class="font-medium">{{ toRow }}</span>
          {{ ' ' }}
          of
          {{ ' ' }}
          <span class="font-medium">{{ totalItems }}</span>
          {{ ' ' }}
          results
        </p>
      </div>
      <div>
        <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
     
         <Link
            v-for="(link, index)  in links"
            :key = "index"
            :href = "link.url + '&search=' + search + '&filter=' + filterUrl"
            :class="link.active ? 'relative z-10 inline-flex items-center bg-success px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600' : 'relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0' "
            >
            <span v-html="link.label"></span>
         </Link>
        
        </nav>
      </div>
    </div>
  </div>
<div class="row mt-5 mb-10">
  <div class="col-sm-12 col-md-4 d-flex align-items-center justify-content-center justify-content-md-start">
    <div class="dataTables_length" id="kt_ecommerce_products_table_length">
      <!-- <label>
        <select name="kt_ecommerce_products_table_length" aria-controls="kt_ecommerce_products_table" class="form-select form-select-sm form-select-solid">
          <option value="10">10</option>
          <option value="25">25</option>
          <option value="50">50</option><option value="100">100</option>
        </select>
      </label> -->
    </div>
  </div>
</div>

</template>

<script setup>

import { Link } from "@inertiajs/vue3";
defineProps(['prev','next','totalItems','links','fromRow','toRow','lastPage','search','filterUrl']);

</script>