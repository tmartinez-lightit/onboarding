import { useState } from "react";
import { useQuery } from "@tanstack/react-query";
import {
  createColumnHelper,
  getCoreRowModel,
  useReactTable,
} from "@tanstack/react-table";
import { useQueryState } from "nuqs";

import { City, getCitiesQuery } from "~/api";
import { Pagination, Table, Title } from "~/shared/components/ui";
import { Button, Modal } from "~/ui";
import { CityRow, CreateCityForm } from "./components";

export const Cities = () => {
  const [page, setPage] = useQueryState("page", {
    defaultValue: "1",
  });
  const [isModalOpen, setIsModalOpen] = useState(false);

  const {
    data: paginatedCities,
    isLoading: isLoadingCities,
    refetch,
  } = useQuery(getCitiesQuery(page));

  const columnHelper = createColumnHelper<City>();

  const columns = [
    columnHelper.accessor("name", {
      header: "City Name",
      cell: (info) => <CityRow city={info.row.original} onUpdate={refetch} />,
    }),
  ];

  const table = useReactTable({
    data: paginatedCities?.data ?? [],
    columns,
    getCoreRowModel: getCoreRowModel(),
  });

  const onCloseModal = () => {
    setIsModalOpen(false);
  };

  const onCityCreated = () => {
    onCloseModal();
    refetch();
  };

  return (
    <div className="px-4 sm:px-6 lg:px-8">
      <div className="flex items-baseline justify-between">
        <Title title="Cities" />
        <Button onClick={() => setIsModalOpen(true)}>Add City</Button>
      </div>
      <Modal show={isModalOpen} onClose={onCloseModal} title="Add City">
        <CreateCityForm onSuccess={onCityCreated} />
      </Modal>

      <Table table={table} loading={isLoadingCities} />

      <Pagination
        currentPage={Number(page)}
        totalPages={paginatedCities?.pagination?.totalPages ?? 0}
        onPageChange={(newPage) => setPage(newPage.toString())}
      />
    </div>
  );
};
