import { defineStore } from 'pinia';

export const useCalendarScheduleSidebar = defineStore('calendar-schedule', {
    state: () => ({
        isOpen: false,
        apptDate: '',
        startDate: '',
        endDate: '',
        selectedSalesId: 0,
        salesPerson: [],
        selectedSalesPerson: [],
    }),
    actions: {
        open() {
            this.isOpen = true;
        },
        close() {
            this.isOpen = false;
        },
        setApptDate(apptDate) {
            this.apptDate = apptDate;
        },
        setStartDate(startDate) {
            this.startDate = startDate;
        },
        setEndDate(endDate) {
            this.endDate = endDate;
        },
        setSalesPerson(salesperson) {
            this.salesPerson = salesperson;
        },
        setSelectedSalesPerson(salesperson) {
            this.selectedSalesPerson = salesperson;
        },
        setSelectedSalesId(salesid) {
            this.selectedSalesId = salesid;
        }
    }
});