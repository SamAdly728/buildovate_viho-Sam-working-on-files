<template>
    <div>
      <input type="file" @change="readExcel" />
      <table v-if="excelData.length">
        <tr v-for="(row, index) in excelData" :key="index">
          <td v-for="(cell, cellIndex) in row" :key="cellIndex">{{ cell }}</td>
        </tr>
      </table>
    </div>
  </template>
  
  <script>
  import * as XLSX from 'xlsx';
  
  export default {
    data() {
      return {
        excelData: []
      };
    },
    methods: {
      readExcel(event) {
        const file = event.target.files[0];
        const reader = new FileReader();
        reader.onload = (e) => {
          const data = e.target.result;
          const workbook = XLSX.read(data, { type: 'binary' });
          const firstSheetName = workbook.SheetNames[0];
          const worksheet = workbook.Sheets[firstSheetName];
          this.excelData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });
        };
        reader.readAsBinaryString(file);
      }
    }
  };
  </script>
  