import { useMutation } from "@tanstack/react-query";

import { City, deleteCityQuery } from "~/api";
import { Button, errorToast, Modal, TOAST_TYPES, useToastStore } from "~/ui";

interface DeleteCityModalProps {
  city: City;
  show: boolean;
  onClose: () => void;
  onDelete: () => void;
}

export const DeleteCityModal = ({
  city,
  show,
  onClose,
  onDelete,
}: DeleteCityModalProps) => {
  const { pushToast } = useToastStore();

  const deleteCityMutation = useMutation({
    mutationFn: async () => {
      await deleteCityQuery.mutation(city.id);
    },
    onSuccess: () => {
      onDelete();
      pushToast({
        type: TOAST_TYPES.success,
        title: "Success",
        message: "City deleted successfully",
      });
    },
    onError: (error) => {
      errorToast(error);
    },
  });

  return (
    <Modal
      show={show}
      onClose={onClose}
      title="Delete City"
      description={`Are you sure you want to delete ${city.name}?`}
    >
      <div className="flex justify-end gap-3">
        <Button variant="tertiary" onClick={onClose}>
          Cancel
        </Button>
        <Button
          variant="primary"
          className="bg-red-600 hover:bg-red-500"
          onClick={() => {
            deleteCityMutation.mutate();
            onClose();
          }}
        >
          Delete
        </Button>
      </div>
    </Modal>
  );
};
