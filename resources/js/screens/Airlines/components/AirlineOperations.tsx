import { useState } from "react";
import { useMutation, useQuery, useQueryClient } from "@tanstack/react-query";

import {
  AirlineWithCities,
  getCitiesQueryBySearch,
  toggleAirlineCityQuery,
} from "~/api";
import MultiSelect, { Option } from "~/shared/components/ui/Select/MultiSelect";

interface AirlineOperationsProps {
  airline: AirlineWithCities;
}

const AirlineOperations = ({ airline }: AirlineOperationsProps) => {
  const queryClient = useQueryClient();
  const [searchQuery, setSearchQuery] = useState("");
  const [selectedCities, setSelectedCities] = useState<Option[]>(
    airline.cities.map((city) => ({
      id: city.id,
      label: city.name,
    })),
  );

  const { data: citiesResponse, isLoading: citiesLoading } = useQuery({
    ...getCitiesQueryBySearch(searchQuery),
  });

  const { mutate: toggleCities } = useMutation({
    mutationFn: (cityIds: string[]) =>
      toggleAirlineCityQuery.mutation(airline.id.toString(), cityIds),
    onSuccess: (airline: AirlineWithCities) => {
      setSelectedCities(
        airline.cities.map((city) => ({
          id: city.id,
          label: city.name,
        })),
      );

      queryClient.invalidateQueries({
        queryKey: ["airline", airline.id.toString()],
      });
    },
  });

  const allCities =
    citiesResponse?.data.map((city) => ({
      id: city.id,
      label: city.name,
    })) ?? [];

  const handleCitiesChange = (newSelection: Option[]) => {
    const citiesToDelete = selectedCities.filter(
      (city) => !newSelection.includes(city),
    );
    const cityIds = citiesToDelete.map((city) => city.id.toString());
    toggleCities(cityIds);

    setSelectedCities(newSelection);
  };

  return (
    <div className="space-y-4">
      <h3 className="text-lg font-medium">Manage Operating Cities</h3>
      <MultiSelect
        options={allCities}
        value={selectedCities}
        onSearch={setSearchQuery}
        onChange={handleCitiesChange}
        placeholder="Select cities..."
        className="w-full max-w-xl"
        disabled={citiesLoading}
      />
    </div>
  );
};

export default AirlineOperations;
