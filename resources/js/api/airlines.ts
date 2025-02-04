import type { ServiceResponse } from "./api.types";
import { api } from "./axios";
import { City } from "./cities";

const DOMAIN = "airline";
const ALL = "all";

export interface Airline {
  id: number;
  name: string;
  description: string;
  cities: City[];
}

export const getAirlinesQuery = (page: string) => ({
  queryKey: [DOMAIN, ALL, "getAirlinesQuery", page],
  queryFn: async () => {
    const response = await api.get<ServiceResponse<Airline[]>>(
      `/airlines?page=${page}&with=cities`,
    );
    return response.data;
  },
});
