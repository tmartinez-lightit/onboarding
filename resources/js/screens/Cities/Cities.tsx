import { useQuery } from "@tanstack/react-query";
import {
  createColumnHelper,
  getCoreRowModel,
  useReactTable,
} from "@tanstack/react-table";
import { useQueryState } from "nuqs";

import { City, getCitiesQuery } from "~/api";
import { Pagination, Table, Title } from "~/shared/components/ui";

export const Cities = () => {
  const [page, setPage] = useQueryState("page", {
    defaultValue: "1",
  });

  const { data: paginatedCities, isLoading: isLoadingCities } = useQuery(
    getCitiesQuery(page),
  );

  const columnHelper = createColumnHelper<City>();

  const columns = [
    columnHelper.accessor("name", {
      header: "City Name",
      cell: (info) => info.getValue(),
    }),
  ];

  const table = useReactTable({
    data: paginatedCities?.data ?? [],
    columns,
    getCoreRowModel: getCoreRowModel(),
  });

  return (
    <div className="px-4 sm:px-6 lg:px-8">
      <Title title="Cities" />

      <Table table={table} loading={isLoadingCities} />

      <Pagination
        currentPage={Number(page)}
        totalPages={paginatedCities?.pagination?.totalPages ?? 0}
        onPageChange={(newPage) => setPage(newPage.toString())}
      />
    </div>
  );
};
