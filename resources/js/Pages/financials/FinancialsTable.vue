<script setup>
import { onMounted, ref } from "vue";
// import RichTable from "@/components/RichTable.vue";
// import { Header } from "vue3-easy-data-table";

const headers = [
  { text: "", value: "actions" },
  { text: "Invoice No.", value: "invoice_no", sortable: true },
  { text: "Created", value: "date_created", sortable: true },
  { text: "Client", value: "client", sortable: true },
  { text: "Job", value: "job", sortable: true },
  { text: "Sales Person", value: "sales_person", sortable: true },
  { text: "Due Date", value: "due_date", sortable: true },
  { text: "Received", value: "received.", sortable: true },
  { text: "Title", value: "title", sortable: true },
  { text: "Status", value: "status", sortable: true },
  { text: "Method", value: "method", sortable: true },
  { text: "Amount", value: "amount", sortable: true },
  { text: "Date Paid", value: "date_paid", sortable: true },
  { text: "Sent", value: "sent", sortable: true },
  { text: "Reminders", value: "reminders", sortable: true }
];

const items = ref([
  {
    invoice_no: "INV0001",
    date_created: "2024-01-16 08:12:00",
    client: "John Doe",
    job: "Anything Under the Sun",
    sales_person: "Rick Michone",
    due_date: "2024-01-25 08:12:00",
    received: "yes",
    title: "Another Title",
    status: "pending",
    method: "cash",
    amount: "$1,200.00",
    date_paid: "2024-01-22 14:12:00",
    sent: "yes",
    reminders: "Paid via Gcash"
  },
  {
    invoice_no: "INV0002",
    date_created: "2024-01-18 09:30:00",
    client: "Jane Smith",
    job: "Graphic Design Services",
    sales_person: "Emily Johnson",
    due_date: "2024-01-28 09:30:00",
    received: "no",
    title: "Design Project Invoice",
    status: "pending",
    method: "credit card",
    amount: "$2,500.00",
    date_paid: null,
    sent: "yes",
    reminders: "Payment overdue"
  },
  {
    invoice_no: "INV0003",
    date_created: "2024-01-20 11:45:00",
    client: "Alex Johnson",
    job: "Consulting Services",
    sales_person: "Michael Anderson",
    due_date: "2024-02-05 11:45:00",
    received: "yes",
    title: "Consultation Invoice",
    status: "paid",
    method: "bank transfer",
    amount: "$3,800.00",
    date_paid: "2024-01-30 14:20:00",
    sent: "yes",
    reminders: null
  },
  {
    invoice_no: "INV0004",
    date_created: "2024-01-22 14:00:00",
    client: "Robert White",
    job: "IT Support",
    sales_person: "Jessica Martinez",
    due_date: "2024-02-10 14:00:00",
    received: "no",
    title: "Support Services Invoice",
    status: "pending",
    method: "paypal",
    amount: "$1,000.00",
    date_paid: null,
    sent: "yes",
    reminders: "Payment due soon"
  },
  {
    invoice_no: "INV0005",
    date_created: "2024-01-25 10:20:00",
    client: "Samantha Brown",
    job: "Web Development",
    sales_person: "Daniel Turner",
    due_date: "2024-02-15 10:20:00",
    received: "yes",
    title: "Web Dev Services Invoice",
    status: "paid",
    method: "check",
    amount: "$4,500.00",
    date_paid: "2024-02-05 12:45:00",
    sent: "yes",
    reminders: null
  },
  {
    invoice_no: "INV0006",
    date_created: "2024-01-28 12:15:00",
    client: "George Davis",
    job: "Marketing Campaign",
    sales_person: "Ella Parker",
    due_date: "2024-02-20 12:15:00",
    received: "no",
    title: "Marketing Invoice",
    status: "pending",
    method: "wire transfer",
    amount: "$2,200.00",
    date_paid: null,
    sent: "yes",
    reminders: "Payment overdue"
  }
]);

const rowData = ref([]);
</script>
<template>
  <div class="table-responsive">
    <EasyDataTable
      :headers="headers"
      :items="items"
      :search-value="searchValue"
    >
      <template #header="header">
        <div class="custom-header">
          <div class="custom-column">{{ header.text.toUpperCase() }}</div>
        </div>
      </template>
      <template #header-actions="header">
        <input type="checkbox" />
      </template>
      <template #item-actions="item">
        <input type="checkbox" />
      </template>

      <template #item-client="item">
        <div>
          <strong>{{ item.client }}</strong>
        </div>
        <div>{{ item.email }}</div>
      </template>
    </EasyDataTable>
  </div>
</template>
