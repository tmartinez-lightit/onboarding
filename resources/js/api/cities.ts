import type { ServiceResponse } from "./api.types";
import { api } from "./axios";

const DOMAIN = "city";
const ALL = "all";

export interface City {
  id: number;
  name: string;
}

export const getCitiesQuery = (page: string) => ({
  queryKey: [DOMAIN, ALL, "getCitiesQuery", page],
  queryFn: async () => {
    const response = await api.get<ServiceResponse<City[]>>(
      `/cities?page=${page}`,
    );

    return response.data;
  },
});
