import type { ServiceResponse } from "./api.types";
import { api } from "./axios";

const DOMAIN = "airline";
const ALL = "all";

export interface Airline {
  id: number;
  name: string;
  description: string;
  activeFlightsCount: number;
}

export const getAirlinesQuery = (page: string) => ({
  queryKey: [DOMAIN, ALL, "getAirlinesQuery", page],
  queryFn: async () => {
    const response = await api.get<ServiceResponse<Airline[]>>(
      `/airlines?page=${page}`,
    );
    return response.data;
  },
});
