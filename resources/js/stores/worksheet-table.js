import { defineStore } from 'pinia';

export const useWorksheet = defineStore('worksheet-table', {
  state: () => ({
    worksheet: [],
    loading: false,
    clientPrice: 0.0,
    builderCost: 0.0,
    markUp: 0.0,
    margin: 0.0,
    profit: 0.0,
    discount: 0.0,
    paymentSchedulePrice: 0.0
  }),
  actions: {
      setWorksheet(worksheet) {
        this.worksheet = worksheet;
      },
      setLoading(loading){
        this.loading = loading;
      },
      setClientPrice(price){
        this.clientPrice = price;
      },
      setEstimatedProfit(price){
        this.profit = price;
      },
      setTotalMargin(price){
        this.margin = price;
      },
      setSumBuilderCost(price){
        this.builderCost = price;
      },
      setTotalMarkup(price){
        this.markUp = price;
      },
      setDiscount(price){
        this.discount = price;
      },
      setPaymentSchedulePrice(price){
        this.paymentSchedulePrice = price;
      }
   }
});