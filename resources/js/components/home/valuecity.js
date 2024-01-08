import { ref } from 'vue';

// export const valuecity = ref({
//     city: localStorage.getItem('city'),
    
//     setCity(value) {
//         this.city = value;
//     }
// });
export const valuecity = ref(localStorage.getItem('city'));
export const setCity = (value) => (valuecity.value = value);