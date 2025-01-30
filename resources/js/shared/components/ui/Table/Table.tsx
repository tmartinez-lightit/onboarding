import { flexRender, Table as ReactTable } from "@tanstack/react-table";

import { Spinner } from "~/components";

interface TableProps<T> {
  table: ReactTable<T>;
  loading?: boolean;
}

export const Table = <T,>({ table, loading }: TableProps<T>) => {
  const renderTableBody = () => {
    if (loading) {
      return (
        <tr>
          <td colSpan={table.getAllColumns().length} className="text-center">
            <div className="flex items-center justify-center py-4">
              <Spinner size="lg" />
            </div>
          </td>
        </tr>
      );
    }

    if (table.getRowModel().rows.length === 0) {
      return (
        <tr>
          <td
            colSpan={table.getAllColumns().length}
            className="py-4 text-center text-sm text-gray-500"
          >
            No items found
          </td>
        </tr>
      );
    }

    return table.getRowModel().rows.map((row) => (
      <tr key={row.id}>
        {row.getVisibleCells().map((cell) => (
          <td
            key={cell.id}
            className="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900 sm:pl-6"
          >
            {flexRender(cell.column.columnDef.cell, cell.getContext())}
          </td>
        ))}
      </tr>
    ));
  };

  return (
    <div className="overflow-hidden bg-white shadow-md ring-1 ring-black/5 sm:rounded-lg">
      <table className="min-w-full divide-y divide-gray-200">
        <thead>
          {table.getHeaderGroups().map((headerGroup) => (
            <tr key={headerGroup.id}>
              {headerGroup.headers.map((header) => (
                <th
                  key={header.id}
                  scope="col"
                  className="bg-gray-50 py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                >
                  {flexRender(
                    header.column.columnDef.header,
                    header.getContext(),
                  )}
                </th>
              ))}
            </tr>
          ))}
        </thead>

        <tbody className="divide-y divide-gray-200 bg-white">
          {renderTableBody()}
        </tbody>
      </table>
    </div>
  );
};
