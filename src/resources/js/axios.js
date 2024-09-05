import axios from 'axios';

const axiosInstance = axios.create({
  baseURL: 'http://localhost:8088', // Your Laravel backend URL
  withCredentials: true, // Important for Sanctum to work with cookies
});

export default axiosInstance;