import { useQuery } from "@tanstack/react-query";
import {
  createColumnHelper,
  getCoreRowModel,
  useReactTable,
} from "@tanstack/react-table";
import { useQueryState } from "nuqs";

import { Airline, getAirlinesQuery } from "~/api";
import { Pagination, Table, Title } from "~/shared/components/ui";
import { Button, Modal } from "~/ui";

export const Airlines = () => {
  const [page, setPage] = useQueryState("page", {
    defaultValue: "1",
  });

  const { data: paginatedAirlines, isLoading: isLoadingAirlines } = useQuery(
    getAirlinesQuery(page),
  );

  const columnHelper = createColumnHelper<Airline>();

  const columns = [
    columnHelper.accessor("name", {
      header: "Airline Name",
      cell: (info) => <div className="max-w-xs">{info.getValue()}</div>,
    }),
    columnHelper.accessor("description", {
      header: "Description",
      cell: (info) => (
        <div className="max-w-md whitespace-normal">{info.getValue()}</div>
      ),
    }),
    columnHelper.accessor("cities", {
      header: "Cities",
      cell: (info) => {
        const cities = info.getValue();
        return (
          <div className="max-w-xs whitespace-normal">
            {cities?.length ? cities.map((city) => city.name).join(", ") : "-"}
          </div>
        );
      },
    }),
  ];

  const table = useReactTable({
    data: paginatedAirlines?.data ?? [],
    columns,
    getCoreRowModel: getCoreRowModel(),
  });

  return (
    <div className="px-4 sm:px-6 lg:px-8">
      <div className="flex items-baseline justify-between">
        <Title title="Airlines" />
      </div>

      <Table table={table} loading={isLoadingAirlines} />

      <Pagination
        currentPage={Number(page)}
        totalPages={paginatedAirlines?.pagination?.totalPages ?? 0}
        onPageChange={(newPage) => setPage(newPage.toString())}
      />
    </div>
  );
};
