import { useMutation, useQuery } from "@tanstack/react-query";

import {
  addCitiesToAirlineQuery,
  removeCitiesFromAirlineQuery,
} from "~/api/airlines";
import { getCitiesQuery } from "~/api/cities";
import type { City } from "~/api/cities";
import { Select, SelectOption } from "~/shared";

interface AirlineCitiesManagerProps {
  airlineId: string;
  currentCities: City[];
}

export const AirlineCitiesManager = ({
  airlineId,
  currentCities,
}: AirlineCitiesManagerProps) => {
  const { data: citiesData } = useQuery(getCitiesQuery("1"));

  const availableCities = citiesData?.data.filter(
    (city) => !currentCities.some((current) => current.id === city.id),
  );

  const { mutate: addCitiesToAirline } = useMutation({
    mutationFn: addCitiesToAirlineQuery(airlineId, cities),
  });

  const handleAddCities = (selected: SelectOption | SelectOption[] | null) => {
    if (!selected) return;

    const cityIds = Array.isArray(selected)
      ? selected.map((option) => option.value.toString())
      : [selected.value.toString()];

    addCitiesToAirline.mutate(cityIds);
  };

  const handleRemoveCity = (cityId: number) => {
    removeCitiesFromAirlineQuery(airlineId, [cityId.toString()]);
  };

  return (
    <div className="space-y-4">
      <div>
        <h2 className="mb-2 text-xl font-semibold text-gray-700">
          Manage Destinations
        </h2>

        <Select
          isMulti
          className="mb-4"
          options={availableCities?.map((city) => ({
            value: city.id,
            label: city.name,
          }))}
          onChange={(value) => handleAddCities(value)}
          placeholder="Add new destinations..."
        />

        <div className="grid grid-cols-2 gap-4 md:grid-cols-3">
          {currentCities.map((city) => (
            <div
              key={city.id}
              className="group relative rounded-md bg-gray-50 p-4"
            >
              <div className="font-medium text-gray-800">{city.name}</div>
              <button
                onClick={() => handleRemoveCity(city.id)}
                className="absolute right-2 top-2 hidden rounded-full bg-red-100 p-1 text-red-600 hover:bg-red-200 group-hover:block"
              >
                <svg
                  className="h-4 w-4"
                  fill="none"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  strokeWidth="2"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path d="M6 18L18 6M6 6l12 12"></path>
                </svg>
              </button>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
};
